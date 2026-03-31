<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    // ── Albums (Categories) ──────────────────────────

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('order_by', 'asc')->withCount('galleries');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('cover', function ($row) {
                    $first = $row->galleries()->orderBy('order_by')->first();
                    if ($first) {
                        return '<img src="' . asset($first->image) . '" width="60" height="45" style="object-fit:cover; border-radius:6px;">';
                    }
                    return '<span class="text-muted">No image</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-success ManageBtn" data-id="' . $row->id . '" data-name="' . $row->name . '">
                            <i class="ri-image-line"></i> Images
                        </button>
                        <button class="btn btn-sm btn-info EditAlbumBtn" data-id="' . $row->id . '" data-name="' . $row->name . '" data-order="' . $row->order_by . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="' . route('gallery.album.delete', $row->id) . '">
                            <i class="ri-delete-bin-fill"></i>
                        </button>';
                })
                ->rawColumns(['cover', 'action'])
                ->make(true);
        }

        return view('admin.gallery.index');
    }

    public function storeAlbum(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        Category::create([
            'name'       => $request->name,
            'order_by'   => $request->order_by ?? 0,
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message' => 'Album created successfully!']);
    }

    public function updateAlbum(Request $request)
    {
        $album = Category::findOrFail($request->id);
        $request->validate(['name' => 'required|unique:categories,name,' . $album->id]);
        $album->update([
            'name'       => $request->name,
            'order_by'   => $request->order_by ?? 0,
            'updated_by' => auth()->id(),
        ]);
        return response()->json(['message' => 'Album updated successfully!']);
    }

    public function destroyAlbum($id)
    {
        $album = Category::findOrFail($id);
        // Delete all images in album
        foreach ($album->galleries as $img) {
            if (File::exists(public_path($img->image))) File::delete(public_path($img->image));
        }
        $album->galleries()->delete();
        $album->delete();
        return response()->json(['message' => 'Album and all images deleted!']);
    }

    // ── Images ───────────────────────────────────────

    public function getImages(Request $request, $categoryId)
    {
        if ($request->ajax()) {
            $data = Gallery::where('category_id', $categoryId)->orderBy('order_by', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('preview', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="70" height="55" style="object-fit:cover; border-radius:6px;">';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info EditImageBtn" 
                            data-id="' . $row->id . '" 
                            data-title="' . $row->title . '" 
                            data-order="' . $row->order_by . '"
                            data-image="' . $row->image . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteImageBtn" data-delete-url="' . route('gallery.image.delete', $row->id) . '">
                            <i class="ri-delete-bin-fill"></i>
                        </button>';
                })
                ->rawColumns(['preview', 'action'])
                ->make(true);
        }
    }

    public function storeImages(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'images'      => 'required',
            'images.*'    => 'image|max:5120',
        ]);

        if (!File::exists(public_path('uploads/gallery'))) {
            File::makeDirectory(public_path('uploads/gallery'), 0755, true);
        }

        $captions = $request->input('captions', []);

        foreach ($request->file('images') as $index => $image) {
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $name);
            Gallery::create([
                'category_id' => $request->category_id,
                'title'       => $captions[$index] ?? null,
                'order_by'    => $request->order_by ?? 0,
                'image'       => 'uploads/gallery/' . $name,
                'created_by'  => auth()->id(),
            ]);
        }

        return response()->json(['message' => count($request->file('images')) . ' image(s) uploaded!']);
    }

    public function updateImage(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $data = [
            'title'      => $request->title ?? null,
            'order_by'   => $request->order_by ?? 0,
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('image')) {
            if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));
            $image = $request->file('image');
            $name  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $name);
            $data['image'] = 'uploads/gallery/' . $name;
        }

        $gallery->update($data);
        return response()->json(['message' => 'Image updated!']);
    }

    public function destroyImage($id)
    {
        $gallery = Gallery::findOrFail($id);
        if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));
        $gallery->delete();
        return response()->json(['message' => 'Image deleted!']);
    }
}