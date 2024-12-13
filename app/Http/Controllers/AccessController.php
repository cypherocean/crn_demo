<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccessController extends Controller
{
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
