<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('id', 'name')->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .= '<a href="' . route('permission.view', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;';



                    $return .= '<a href="' . route('permission.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;';



                    $return .= '<a class="btn btn-default btn-xs" href="javascript:void(0);" onclick="delete_func(this);" data-id="' . $data->id . '">
                                            <i class="fa fa-trash"></i>
                                        </a> &nbsp;';


                    $return .= '</div>';

                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('permission.index');
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $user = User::find($request->user_id);
        $role = $user->roles()->first();

        if ($role) {
            $role->permissions()->syncWithoutDetaching([$request->permission_id]);
        }

        return redirect()->back()->with('success', 'Permission assigned successfully.');
    }
}
