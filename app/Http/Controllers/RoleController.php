<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use DB;

class RoleController extends Controller
{

    /** index */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('id', 'name')->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .= '<a href="' . route('roles.view', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                <i class="fa fa-eye"></i>
                            </a> &nbsp;';



                    $return .= '<a href="' . route('roles.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                <i class="fa fa-edit"></i>
                            </a> &nbsp;';



                    $return .= '<a class="btn btn-default btn-xs" href="javascript:void(0);" onclick="delete_func(this);" data-id="' . $data->id . '">
                                <i class="fa fa-trash"></i>
                            </a> &nbsp;';


                    $return .= '</div>';

                    return $return;
                })

                ->editColumn('name', function ($data) {
                    return ucfirst(str_replace('_', ' ', $data->name));
                })

                ->rawColumns(['name', 'action'])
                ->make(true);
        }

        return view('role.index');
    }
    /** index */

    /** create */
    public function create(Request $request)
    {
        $permissions = Permission::get();
        return view('role.create', ['permissions' => $permissions]);
    }
    /** create */

    /** insert */
    public function insert(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $curd = [
            'name' => $request->name,
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $role = Role::create($curd);
        if ($role) {
            $role->givePermissionTo($request->permissions);

            return redirect()->route('roles')->with('success', 'Record inserted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to insert record')->withInput();
        }
    }
    /** insert */

    /** edit */
    public function edit(Request $request)
    {
        if (isset($request->id) && $request->id != '' && $request->id != null)
            $id = base64_decode($request->id);
        else
            return redirect()->route('role')->with('error', 'Something went wrong');

        $data = Role::find($id);
        $permissions = Permission::get();
        $role_permissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role.edit')->with(['data' => $data, 'permissions' => $permissions, 'role_permissions' => $role_permissions]);
    }
    /** edit */

    /** update */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->updated_at = date('Y-m-d H:i:s');

        if ($role->save()) {
            $role->syncPermissions($request->permissions);

            return redirect()->route('role')->with('success', 'Record updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update record')->withInput();
        }
    }
    /** update */

    /** view */
    public function view(Request $request)
    {
        if (isset($request->id) && $request->id != '' && $request->id != null)
            $id = base64_decode($request->id);
        else
            return redirect()->route('role')->with('error', 'Something went wrong');

        $data = Role::find($id);
        $permissions = Permission::get();
        $role_permissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role.view')->with(['data' => $data, 'permissions' => $permissions, 'role_permissions' => $role_permissions]);
    }
    /** view */

    /** delete */
    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = $request->id;
            $delete = Role::where(['id' => $id])->delete();

            if ($delete)
                return response()->json(['code' => 200]);
            else
                return response()->json(['code' => 201]);
        } else {
            return response()->json(['code' => 201]);
        }
    }
    /** delete */
}
