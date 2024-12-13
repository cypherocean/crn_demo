<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::getUserList($request);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .=  '<a href="' . route('users.view', ['id' => $data->id]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;';



                    $return .= '<a href="' . route('users.edit', ['id' => $data->id]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;';


                    $return .= '<a href="javascript:;" class="btn btn-default btn-xs" onclick="change_status(this);" data-status="delete" data-id="' . $data->id . '">
                                            <i class="fa fa-trash"></i>
                                        </a> &nbsp;';

                    $return .= '</div>';

                    return $return;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function insert(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $user = User::createOrUpdate($request);
        if ($user['status']) {
            return redirect()->route('users')->with('success', 'Record inserted successfully');
        }
        return redirect()->back()->with('error', 'Failed to insert record')->withInput();
    }

    public function edit($id)
    {
        $data = User::getSpecificUser($id);
        return view('users.edit', compact('data'));
    }

    public function view($id)
    {
        $data = User::getSpecificUser($id);
        return view('users.view', compact('data'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $user = User::createOrUpdate($request);
        if ($user['status']) {
            return redirect()->route('users')->with('success', 'Record updated successfully');
        }
        return redirect()->back()->with('error', 'Failed to update record')->withInput();
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }
        $id = $request->id;
        $data = User::where(['id' => $id])->first();
        if (!empty($data)) {
            $process = User::where(['id' => $id])->delete();

            if ($process)
                return response()->json(['code' => 200]);
            else
                return response()->json(['code' => 201]);
        } else {
            return response()->json(['code' => 201]);
        }
    }
}
