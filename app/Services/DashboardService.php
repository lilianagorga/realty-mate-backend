<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardService
{
    public function getDashboardData()
    {
        return Cache::remember('dashboard', 60, function () {
            $users = User::with(['roles.permissions', 'permissions'])->get();
            $roles = Role::all()->pluck('name');
            $rolesWithAssociatedPermissions = Role::with('permissions')->get();
            $permissions = Permission::all()->pluck('name');

            return [
                'users' => $users,
                'roles' => $roles,
                'rolesWithAssociatedPermissions' => $rolesWithAssociatedPermissions,
                'permissions' => $permissions,
            ];
        });
    }
}
