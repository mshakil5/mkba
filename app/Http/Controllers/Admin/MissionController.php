<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mission::orderBy('serial');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    return $row->status 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown">
                                <i class="ri-more-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item EditBtn" data-id="'.$row->id.'">
                                        <i class="ri-pencil-fill me-2"></i>Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="'.route('mission.delete', $row->id).'">
                                        <i class="ri-delete-bin-fill me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.mission.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        Mission::create([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'serial' => $request->serial ?? 0,
            'status' => $request->status ?? 1,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Mission created successfully']);
    }

    public function edit($id)
    {
        return Mission::findOrFail($id);
    }

    public function update(Request $request)
    {
        $mission = Mission::findOrFail($request->id);

        $mission->update([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'serial' => $request->serial,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Mission updated successfully']);
    }

    public function destroy($id)
    {
        Mission::findOrFail($id)->delete();

        return response()->json(['message' => 'Mission deleted successfully']);
    }


}
