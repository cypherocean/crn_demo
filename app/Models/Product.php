<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    public static function getProductList($request)
    {
        return self::all();
    }

    public static function createOrUpdate(Request $request): array
    {
        $id = $request->input('id', null);
        $data = [
            'name' => $request->input('name', null),
            'price' => $request->input('price', 0),
        ];

        if ($id) {
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $updated = self::where('id', $id)->update($data);
            return [
                'status' => $updated,
                'message' => $updated ? 'Record updated successfully' : 'Failed to update record',
            ];
        } else {
            $data['created_by'] = Auth::id();
            $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $inserted = self::insert($data);
            return [
                'status' => $inserted,
                'message' => $inserted ? 'Record inserted successfully' : 'Failed to insert record',
            ];
        }
    }

    public static function getSpecificProduct($id) {
        return self::find($id);
    }
}
