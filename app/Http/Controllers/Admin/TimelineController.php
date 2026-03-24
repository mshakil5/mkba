<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timeline;
use Yajra\DataTables\Facades\DataTables;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Timeline::orderBy('order_by', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('timeline.delete', $row->id).'"><i class="ri-delete-bin-fill"></i></button>';
                })
                ->make(true);
        }
        return view('admin.timeline.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required', // e.g., "Founded"
            'title' => 'required', // e.g., "Establishment"
            'description' => 'required'
        ]);

        Timeline::create($request->all());
        return response()->json(['message' => 'Timeline event added!']);
    }

    public function edit($id)
    {
        return response()->json(Timeline::find($id));
    }

    public function update(Request $request)
    {
        $timeline = Timeline::findOrFail($request->id);
        $timeline->update($request->all());
        return response()->json(['message' => 'Timeline updated successfully!']);
    }

    public function destroy($id)
    {
        Timeline::destroy($id);
        return response()->json(['message' => 'Timeline event deleted!']);
    }
}
