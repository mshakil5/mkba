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
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="'.$row->id.'"><i class="ri-pencil-fill"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('trustee.delete', $row->id).'"><i class="ri-delete-bin-fill"></i></button>';
                })
                ->make(true);
        }
        return view('admin.trustees.index');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'role' => 'required']);
        
        $data = $request->all();
        $data['created_by'] = auth()->id();
        
        // Auto-generate initials if not provided (e.g., "Dr. Rahman Ahmed" -> "RA")
        if (!$request->initials) {
            $words = explode(' ', $request->name);
            $data['initials'] = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        }

        Trustee::create($data);
        return response()->json(['message' => 'Trustee added successfully.']);
    }

    public function edit($id) {
        return response()->json(Trustee::find($id));
    }

    public function update(Request $request) {
        $trustee = Trustee::findOrFail($request->id);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        
        $trustee->update($data);
        return response()->json(['message' => 'Trustee updated successfully.']);
    }

    public function destroy($id) {
        Trustee::destroy($id);
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
