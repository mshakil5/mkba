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
                        if ($first->type === 'video') {
                            return '<video src="' . asset($first->image) . '" width="80" height="52" style="object-fit:cover; border-radius:6px;" muted></video>';
                        }
                        return '<img src="' . asset($first->image) . '" width="80" height="52" style="object-fit:cover; border-radius:6px;">';
                    }
                    return '<span class="text-muted">No media</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-success ManageBtn" data-id="' . $row->id . '" data-name="' . $row->name . '">
                            <i class="ri-image-line"></i> Media
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
        foreach ($album->galleries as $item) {
            if (File::exists(public_path($item->image))) File::delete(public_path($item->image));
        }
        $album->galleries()->delete();
        $album->delete();
        return response()->json(['message' => 'Album and all media deleted!']);
    }

    // ── Images / Videos ─────────────────────────────

    public function getImages(Request $request, $categoryId)
    {
        if ($request->ajax()) {
            $data = Gallery::where('category_id', $categoryId)->orderBy('order_by', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('preview', function ($row) {
                    // Detect by extension as fallback (covers cases where type column is missing/null)
                    $videoExts = ['mp4', 'mov', 'avi', 'webm', 'mkv', 'ogg'];
                    $ext       = strtolower(pathinfo($row->image, PATHINFO_EXTENSION));
                    $isVideo   = in_array($ext, $videoExts) || ($row->type ?? '') === 'video';

                    if ($isVideo) {
                        return '<video width="90" height="60"
                                    style="object-fit:cover; border-radius:6px; display:block; background:#000;"
                                    muted playsinline preload="metadata"
                                    onmouseenter="this.play()"
                                    onmouseleave="this.pause();this.currentTime=0;">
                                    <source src="' . asset($row->image) . '" type="video/' . $ext . '">
                                </video>';
                    }

                    return '<img src="' . asset($row->image) . '"
                                width="90" height="60"
                                style="object-fit:cover; border-radius:6px; display:block;"
                                onerror="this.src=\'' . asset('assets/images/no-image.png') . '\'">';
                })
                ->addColumn('type_badge', function ($row) {
                    $videoExts = ['mp4', 'mov', 'avi', 'webm', 'mkv', 'ogg'];
                    $ext       = strtolower(pathinfo($row->image, PATHINFO_EXTENSION));
                    $isVideo   = in_array($ext, $videoExts) || ($row->type ?? '') === 'video';

                    return $isVideo
                        ? '<span class="badge bg-primary"><i class="ri-video-line"></i> Video</span>'
                        : '<span class="badge bg-success"><i class="ri-image-line"></i> Image</span>';
                })
                ->addColumn('action', function ($row) {
                    $videoExts = ['mp4', 'mov', 'avi', 'webm', 'mkv', 'ogg'];
                    $ext       = strtolower(pathinfo($row->image, PATHINFO_EXTENSION));
                    $type      = in_array($ext, $videoExts) ? 'video' : 'image';

                    return '
                        <button class="btn btn-sm btn-info EditImageBtn"
                            data-id="'    . $row->id     . '"
                            data-title="' . $row->title  . '"
                            data-order="' . $row->order_by . '"
                            data-image="' . $row->image  . '"
                            data-type="'  . $type        . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteImageBtn"
                            data-delete-url="' . route('gallery.image.delete', $row->id) . '">
                            <i class="ri-delete-bin-fill"></i>
                        </button>';
                })
                ->rawColumns(['preview', 'type_badge', 'action'])
                ->make(true);
        }
    }

    public function storeImages(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'files'       => 'required',
            'files.*'     => 'file|max:51200|mimetypes:image/jpeg,image/png,image/gif,image/webp,video/mp4,video/quicktime,video/x-msvideo,video/webm',
        ]);

        foreach (['uploads/gallery/images', 'uploads/gallery/videos'] as $dir) {
            if (!File::exists(public_path($dir))) {
                File::makeDirectory(public_path($dir), 0755, true);
            }
        }

        $captions   = $request->input('captions', []);
        $videoExts  = ['mp4', 'mov', 'avi', 'webm', 'mkv'];
        $uploaded   = 0;

        foreach ($request->file('files') as $index => $file) {
            $ext      = strtolower($file->getClientOriginalExtension());
            // Detect by MIME first, fall back to extension
            $isVideo  = str_starts_with($file->getMimeType(), 'video/') || in_array($ext, $videoExts);
            $folder   = $isVideo ? 'uploads/gallery/videos' : 'uploads/gallery/images';
            $name     = time() . '_' . uniqid() . '.' . $ext;

            $file->move(public_path($folder), $name);

            Gallery::create([
                'category_id' => $request->category_id,
                'title'       => $captions[$index] ?? null,
                'order_by'    => $request->order_by ?? 0,
                'image'       => $folder . '/' . $name,
                'type'        => $isVideo ? 'video' : 'image',   // requires migration
                'created_by'  => auth()->id(),
            ]);

            $uploaded++;
        }

        return response()->json(['message' => $uploaded . ' file(s) uploaded successfully!']);
    }

    public function updateImage(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $data = [
            'title'      => $request->title ?? null,
            'order_by'   => $request->order_by ?? 0,
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => [
                    'file', 'max:51200',
                    'mimetypes:image/jpeg,image/png,image/gif,image/webp,video/mp4,video/quicktime,video/x-msvideo,video/webm',
                ],
            ]);

            if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));

            $file     = $request->file('file');
            $isVideo  = str_starts_with($file->getMimeType(), 'video/');
            $folder   = $isVideo ? 'uploads/gallery/videos' : 'uploads/gallery/images';

            if (!File::exists(public_path($folder))) {
                File::makeDirectory(public_path($folder), 0755, true);
            }

            $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $name);

            $data['image'] = $folder . '/' . $name;
            $data['type']  = $isVideo ? 'video' : 'image';
        }

        $gallery->update($data);
        return response()->json(['message' => 'Media updated!']);
    }

    public function destroyImage($id)
    {
        $gallery = Gallery::findOrFail($id);
        if (File::exists(public_path($gallery->image))) File::delete(public_path($gallery->image));
        $gallery->delete();
        return response()->json(['message' => 'Media deleted!']);
    }
}