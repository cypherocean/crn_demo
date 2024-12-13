<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasPermission($permissions)
    {
        // Convert single permission string to an array for consistency
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        // Collect all permissions from the user's roles
        $userPermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        // Check if the user has any of the specified permissions
        return collect($permissions)->some(fn($permission) => $userPermissions->contains($permission));
    }

    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    public static function getUserList(Request $request)
    {
        return self::all();
    }

    public static function createOrUpdate(Request $request): array
    {
        $id = $request->input('id', null);
        $data = [
            'name' => $request->input('name', null),
            'email' => $request->input('email', null),
        ];

        if ($id) {
            $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            if ($request->has('password') && !empty($request->input('password'))) {
                $data['password'] = bcrypt($request->input('password', '123456789'));
            }

            $updated = self::where('id', $id)->update($data);
            return [
                'status' => $updated,
                'message' => $updated ? 'Record updated successfully' : 'Failed to update record',
            ];
        } else {
            $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['password'] = bcrypt($request->input('password', '123456789'));

            $inserted = self::insert($data);
            return [
                'status' => $inserted,
                'message' => $inserted ? 'Record inserted successfully' : 'Failed to insert record',
            ];
        }
    }

    public static function getSpecificUser($id)
    {
        return self::find($id);
    }
}
