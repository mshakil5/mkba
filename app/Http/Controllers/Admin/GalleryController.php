<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Gallery::orderBy('order_by', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    return '<img src="'.asset($row->image).'" width="50" class="img-thumbnail">';
                })
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('gallery.delete', $row->id).'"><i class="ri-delete-bin-fill"></i></button>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        
        $categories = Category::orderBy('id', 'asc')->get();
        return view('admin.gallery.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate(['category' => 'required', 'image' => 'required|image']);
        
        $data = $request->only('title', 'category', 'order_by');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $name);
            $data['image'] = 'uploads/gallery/'.$name;
        }

        Gallery::create($data);
        return response()->json(['message' => 'Image added to gallery!']);
    }

    public function edit($id) {
        return response()->json(Gallery::find($id));
    }

    public function update(Request $request) {
        $gallery = Gallery::findOrFail($request->id);
        $data = $request->only('title', 'category', 'order_by');

        if ($request->hasFile('image')) {
            if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));
            
            $image = $request->file('image');
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $name);
            $data['image'] = 'uploads/gallery/'.$name;
        }

        $gallery->update($data);
        return response()->json(['message' => 'Gallery updated!']);
    }

    public function destroy($id) {
        $gallery = Gallery::findOrFail($id);
        if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));
        $gallery->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
