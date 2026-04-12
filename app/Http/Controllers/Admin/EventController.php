<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $events = Event::orderByDesc('id');
            return DataTables::of($events)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                                <li class="dropdown-divider"></li>
                                <li><button class="dropdown-item deleteBtn" data-delete-url="'.route('event.delete', $row->id).'"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.events.index');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'order_by'   => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Create a unique name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Define the destination path: public/uploads/events
            $destinationPath = public_path('uploads/events');
            
            // Move the file
            $image->move($destinationPath, $imageName);
            
            // Save the relative path to the database
            $data['image'] = 'uploads/events/' . $imageName;
        }

        Event::create($data);
        return response()->json(['message' => 'Event created successfully.'], 201);
    }


    public function edit($id) {
        return response()->json(Event::findOrFail($id));
    }

    
    public function update(Request $request) {
        $event = Event::findOrFail($request->id);
        $data = $request->all();
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('image')) {
            // 1. Delete the old image if it exists in the public folder
            if ($event->image && File::exists(public_path($event->image))) {
                File::delete(public_path($event->image));
            }

            // 2. Upload the new image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/events');
            
            $image->move($destinationPath, $imageName);
            
            $data['image'] = 'uploads/events/' . $imageName;
        }

        $event->update($data);
        return response()->json(['message' => 'Event updated successfully.']);
    }



    public function destroy($id) {
        $event = Event::findOrFail($id);
        if ($event->image) Storage::disk('public')->delete($event->image);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully.']);
    }


    
}
