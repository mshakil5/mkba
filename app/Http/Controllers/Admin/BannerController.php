<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    protected $pageOptions = [
        'About'      => 'About',
        'Blog'       => 'Blog',
        'Event'      => 'Event',
        'Activities' => 'Activities',
        'Trustee'    => 'Trustee',
        'Contact'    => 'Contact',
        'Gallery'    => 'Gallery',
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = BannerSection::orderBy('id', 'desc');
            
            return DataTables::of($banners)
                ->addIndexColumn()
                ->addColumn('page', function ($row) {
                    $colors = [
                        'About'      => 'primary',
                        'Blog'       => 'info',
                        'Event'      => 'warning',
                        'Activities' => 'success',
                        'Trustee'    => 'secondary',
                        'Contact'    => 'danger',
                        'Gallery'    => 'dark',
                    ];
                    $color = $colors[$row->page] ?? 'secondary';
                    return '<span class="badge bg-' . $color . '">' . $row->page . '</span>';
                })
                ->addColumn('short_title', function ($row) {
                    return $row->short_title ? Str::limit($row->short_title, 30) : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" width="60" height="35" 
                                style="object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge bg-success"><i class="ri-check-line me-1"></i>Active</span>';
                    }
                    return '<span class="badge bg-danger"><i class="ri-close-line me-1"></i>Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="' . $row->id . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" 
                                data-delete-url="' . route('banner-section.delete', $row->id) . '" 
                                data-method="DELETE" 
                                data-table="#bannerTable">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                        ';
                })
                ->rawColumns(['page', 'short_title', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.banner-sections.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page'            => 'required|string|unique:banner_sections,page',
            'name'            => 'nullable|string|max:255',
            'short_title'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'meta_image']);
        $data['created_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'banner');
        }

        // Handle meta image upload
        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = $this->uploadFile($request->file('meta_image'), 'banner/meta');
        }

        BannerSection::create($data);

        return response()->json(['message' => 'Banner section added successfully.']);
    }

    public function edit($id)
    {
        return response()->json(BannerSection::find($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'page'            => 'required|string|unique:banner_sections,page,' . $request->id,
            'name'            => 'nullable|string|max:255',
            'short_title'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'nullable|boolean',
        ]);

        $banner = BannerSection::findOrFail($request->id);
        $data = $request->except(['image', 'meta_image']);
        $data['updated_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'banner');
        }

        // Handle meta image upload
        if ($request->hasFile('meta_image')) {
            if ($banner->meta_image && File::exists(public_path($banner->meta_image))) {
                File::delete(public_path($banner->meta_image));
            }
            $data['meta_image'] = $this->uploadFile($request->file('meta_image'), 'banner/meta');
        }

        $banner->update($data);

        return response()->json(['message' => 'Banner section updated successfully.']);
    }

    public function destroy($id)
    {
        $banner = BannerSection::find($id);

        if ($banner) {
            // Delete banner image
            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            // Delete meta image
            if ($banner->meta_image && File::exists(public_path($banner->meta_image))) {
                File::delete(public_path($banner->meta_image));
            }
            $banner->delete();
        }

        return response()->json(['message' => 'Deleted successfully.']);
    }

    /**
     * Upload file to specified path
     */
    private function uploadFile($file, $path)
    {
        $uploadPath = public_path('uploads/' . $path);
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($uploadPath, $filename);

        return 'uploads/' . $path . '/' . $filename;
    }
}