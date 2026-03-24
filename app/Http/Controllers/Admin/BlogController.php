<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $blogs = Blog::latest()->get();
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    return $row->image ? '<img src="'.asset($row->image).'" width="60" class="rounded">' : 'No Image';
                })
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('blog.delete', $row->id).'"><i class="ri-delete-bin-fill"></i></button>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.blog.index');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|unique:blogs,title',
            'category' => 'required',
            'post_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $name);
            $data['image'] = 'uploads/blogs/'.$name;
        }

        Blog::create($data);
        return response()->json(['message' => 'Blog published successfully!']);
    }

    public function edit($id) {
        return response()->json(Blog::find($id));
    }

    public function update(Request $request) {
        $blog = Blog::findOrFail($request->id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path($blog->image))) File::delete(public_path($blog->image));
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $name);
            $data['image'] = 'uploads/blogs/'.$name;
        }

        $blog->update($data);
        return response()->json(['message' => 'Blog updated successfully!']);
    }

    public function destroy($id) {
        $blog = Blog::find($id);
        if ($blog->image && File::exists(public_path($blog->image))) File::delete(public_path($blog->image));
        $blog->delete();
        return response()->json(['message' => 'Blog deleted!']);
    }



}
