<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trustee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class TrusteeController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $trustees = Trustee::orderBy('order_by', 'asc');
            return DataTables::of($trustees)
                ->addIndexColumn()
                ->addColumn('initials', function($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" width="40" height="40" 
                                style="border-radius:50%; object-fit:cover;">';
                    }
                    return $row->initials;
                })
                ->addColumn('action', function($row) {
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="' . $row->id . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="' . route('trustee.delete', $row->id) . '">
                            <i class="ri-delete-bin-fill"></i>
                        </button>';
                })
                ->rawColumns(['initials', 'action'])
                ->make(true);
        }
        return view('admin.trustees.index');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'role' => 'required']);

        $data = $request->except('image');
        $data['created_by'] = auth()->id();

        // Auto-generate initials
        if (!$request->initials) {
            $words = explode(' ', $request->name);
            $data['initials'] = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        }

        if (!File::exists(public_path('uploads/trustees'))) {
            File::makeDirectory(public_path('uploads/trustees'), 0755, true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/trustees'), $filename);
            $data['image'] = 'uploads/trustees/' . $filename;
        }

        Trustee::create($data);
        return response()->json(['message' => 'Trustee added successfully.']);
    }

    public function edit($id) {
        return response()->json(Trustee::find($id));
    }

    public function update(Request $request) {
        $trustee = Trustee::findOrFail($request->id);

        $data = $request->except('image');
        $data['updated_by'] = auth()->id();
        
        if (!File::exists(public_path('uploads/trustees'))) {
            File::makeDirectory(public_path('uploads/trustees'), 0755, true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($trustee->image && File::exists(public_path($trustee->image))) {
                File::delete(public_path($trustee->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/trustees'), $filename);
            $data['image'] = 'uploads/trustees/' . $filename;
        }

        $trustee->update($data);
        return response()->json(['message' => 'Trustee updated successfully.']);
    }

    public function destroy($id) {
        $trustee = Trustee::find($id);

        // Delete image file
        if ($trustee && $trustee->image && File::exists(public_path($trustee->image))) {
            File::delete(public_path($trustee->image));
        }

        $trustee->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}