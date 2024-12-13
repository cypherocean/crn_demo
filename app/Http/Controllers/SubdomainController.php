<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubdomainController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subdomain::getSubDomainList($request);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .= '<a href="javascript:;" class="btn btn-default btn-xs" onclick="change_status(this);" data-status="delete" data-id="' . $data->id . '">
                                            <i class="fa fa-trash"></i>
                                        </a> &nbsp;';

                    $return .= '</div>';

                    return $return;
                })
                ->editColumn('name', function ($data) {
                    return 'https://' . $data->name . '.' . str_replace('https://', '', config('env.APP_URL'));
                })
                ->rawColumns(['action', 'status', 'name'])
                ->make(true);
        }

        return view('subdomain.index');
    }

    public function create()
    {
        return view('subdomain.create');
    }

    public function insert(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $subDomain = Subdomain::createOrUpdate($request);
        if ($subDomain['status']) {
            return redirect()->route('sub-domain')->with('success', 'Record inserted successfully');
        }
        return redirect()->back()->with('error', 'Failed to insert record')->withInput();
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = $request->id;
            $process = Subdomain::where(['id' => $id])->delete();
            if ($process) {
                return response()->json(['code' => 200]);
            } else {
                return response()->json(['code' => 201]);
            }
        }
    }
}
