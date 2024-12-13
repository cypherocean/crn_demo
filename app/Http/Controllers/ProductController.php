<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::getProductList($request);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .=  '<a href="' . route('products.view', ['id' => $data->id]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;';



                    $return .= '<a href="' . route('products.edit', ['id' => $data->id]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;';

                    $return .= '<a href="javascript:;" class="btn btn-default btn-xs" onclick="change_status(this);" data-status="active" data-id="' . $data->id . '">
                                            <i class="fa fa-trash"></i>
                                        </a> &nbsp;';


                    $return .= '</div>';

                    return $return;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function insert(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $product = Product::createOrUpdate($request);
        if ($product['status']) {
            return redirect()->route('products')->with('success', 'Record inserted successfully');
        }
        return redirect()->back()->with('error', 'Failed to insert record')->withInput();
    }

    public function edit($id)
    {
        $data = Product::getSpecificProduct($id);
        return view('product.edit', compact('data'));
    }

    public function view($id)
    {
        $data = Product::getSpecificProduct($id);
        return view('product.view', compact('data'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            return true;
        }

        $product = Product::createOrUpdate($request);
        if ($product['status']) {
            return redirect()->route('products')->with('success', 'Record updated successfully');
        }
        return redirect()->back()->with('error', 'Failed to update record')->withInput();
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        $id = $request->id;
        $process = Product::where(['id' => $id])->delete();

        if ($process)
            return response()->json(['code' => 200]);
        else
            return response()->json(['code' => 201]);
    }
}
