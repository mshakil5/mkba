<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stat;
use Yajra\DataTables\Facades\DataTables;

class StatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Stat::orderBy('order_by', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('icon_preview', function($row){
                    return '<i class="'.$row->icon_class.' fs-4" style="color:#ff4d4d;"></i>';
                })
                ->addColumn('status', function($row){
                    return $row->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('stats.delete', $row->id).'"><i class="ri-delete-bin-fill"></i></button>';
                })
                ->rawColumns(['icon_preview', 'status', 'action'])
                ->make(true);
        }
        return view('admin.stats.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon_class' => 'required',
            'count'      => 'required',
            'label'      => 'required',
            'order_by'   => 'nullable|integer',
        ]);

        Stat::create([
            'icon_class' => $request->icon_class,
            'count'      => $request->count,
            'label'      => $request->label,
            'order_by'   => $request->order_by ?? 0,
            'is_active'  => $request->has('is_active') ? 1 : 0,
        ]);

        return response()->json(['message' => 'Stat added successfully!']);
    }

    public function edit($id)
    {
        return response()->json(Stat::find($id));
    }

    public function update(Request $request)
    {
        $stat = Stat::findOrFail($request->id);
        
        $request->validate([
            'icon_class' => 'required',
            'count'      => 'required',
            'label'      => 'required',
            'order_by'   => 'nullable|integer',
        ]);

        $stat->update([
            'icon_class' => $request->icon_class,
            'count'      => $request->count,
            'label'      => $request->label,
            'order_by'   => $request->order_by ?? 0,
            'is_active'  => $request->has('is_active') ? 1 : 0,
        ]);

        return response()->json(['message' => 'Stat updated successfully!']);
    }

    public function destroy($id)
    {
        Stat::destroy($id);
        return response()->json(['message' => 'Stat deleted successfully!']);
    }
}