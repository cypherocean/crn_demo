<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subdomain extends Model
{
    public static function getSubDomainList($request)
    {
        return self::all();
    }

    public static function createOrUpdate(Request $request): array
    {
        $data = [
            'name' => $request->input('name', null),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];

        $inserted = self::insert($data);
        return [
            'status' => $inserted,
            'message' => $inserted ? 'Record inserted successfully' : 'Failed to insert record',
        ];
    }
}
