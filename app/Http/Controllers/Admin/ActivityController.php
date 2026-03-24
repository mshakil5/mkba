<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ActivityController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $activities = Activity::orderByDesc('id');
            return DataTables::of($activities)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                                <li class="dropdown-divider"></li>
                                <li><button class="dropdown-item deleteBtn" data-delete-url="'.route('activity.delete', $row->id).'"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.activities.index');
    }

    
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'activity_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Added
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Handle Main Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'activity_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/activities'), $imageName);
            $data['image'] = 'uploads/activities/' . $imageName;
        }

        // Handle Meta Image (SEO)
        if ($request->hasFile('meta_image')) {
            $mImage = $request->file('meta_image');
            $mImageName = 'meta_' . time() . '_' . uniqid() . '.' . $mImage->getClientOriginalExtension();
            $mImage->move(public_path('uploads/activities/meta'), $mImageName);
            $data['meta_image'] = 'uploads/activities/meta/' . $mImageName;
        }

        Activity::create($data);
        return response()->json(['message' => 'Activity created successfully.'], 201);
    }

    public function update(Request $request) {
        $activity = Activity::findOrFail($request->id);
        
        $data = $request->all();
        $data['updated_by'] = auth()->id();

        // Update Main Image
        if ($request->hasFile('image')) {
            if ($activity->image && File::exists(public_path($activity->image))) {
                File::delete(public_path($activity->image));
            }
            $image = $request->file('image');
            $imageName = 'activity_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/activities'), $imageName);
            $data['image'] = 'uploads/activities/' . $imageName;
        }

        // Update Meta Image
        if ($request->hasFile('meta_image')) {
            if ($activity->meta_image && File::exists(public_path($activity->meta_image))) {
                File::delete(public_path($activity->meta_image));
            }
            $mImage = $request->file('meta_image');
            $mImageName = 'meta_' . time() . '_' . uniqid() . '.' . $mImage->getClientOriginalExtension();
            $mImage->move(public_path('uploads/activities/meta'), $mImageName);
            $data['meta_image'] = 'uploads/activities/meta/' . $mImageName;
        }

        $activity->update($data);
        return response()->json(['message' => 'Activity updated successfully.']);
    }


    public function edit($id) {
        return response()->json(Activity::findOrFail($id));
    }



    public function destroy($id) {
        $activity = Activity::findOrFail($id);
        if ($activity->image && File::exists(public_path($activity->image))) {
            File::delete(public_path($activity->image));
        }
        $activity->delete();
        return response()->json(['message' => 'Activity deleted successfully.']);
    }


}
