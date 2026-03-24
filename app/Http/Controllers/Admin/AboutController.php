<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function editAbout()
    {
        $about = About::first(); // Always get the first record
        return view('admin.about.edit', compact('about'));
    }

    // Update or Create the single record
    public function updateAbout(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Find the first record or start a new instance
        $about = About::first() ?? new About();

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($about->image && File::exists(public_path($about->image))) {
                File::delete(public_path($about->image));
            }
            
            $image = $request->file('image');
            $imageName = 'about_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/about'), $imageName);
            $data['image'] = 'uploads/about/' . $imageName;
        }

        // updateOrCreate based on ID if it exists, otherwise just create
        About::updateOrCreate(['id' => $about->id], $data);

        return response()->json(['message' => 'About page content updated successfully!']);
    }
}
