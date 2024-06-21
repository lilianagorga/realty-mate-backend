<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function dashboard(Request $request): RedirectResponse | View
    {
        if (!$request->user()->canAccessDashboard()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to the dashboard.');
        }

        $data = Cache::remember('dashboard', 60, function () {
            $users = User::with(['roles.permissions', 'permissions'])->get();
            $roles = Role::all()->pluck('name');
            $rolesWithAssociatedPermissions = Role::with('permissions')->get();
            $permissions = Permission::all()->pluck('name');

            return compact('users', 'roles', 'rolesWithAssociatedPermissions', 'permissions');
        });

        return view('dashboard.index', $data);
    }

    public function createRole(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string']);
            $role = Role::create(['name' => $validatedData['name'], 'guard_name' => 'web']);
            Cache::forget('dashboard');
            return redirect()->route('dashboard')->with('success', 'Role created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function updateRole(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'permissions' => 'required|array|min:1',
                'permissions.*' => 'required|string|exists:permissions,name'
            ]);
            $role = Role::firstWhere('name', $validatedData['name']);
            if ($role && $validatedData['permissions']) {
                $permissions = Permission::whereIn('name', $validatedData['permissions'])->where('guard_name', 'web')->get();
                foreach ($permissions as $permission) {
                    if (!$role->hasPermissionTo($permission)) {
                        $role->givePermissionTo($permission);
                    }
                }

                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Role permissions updated successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'Role not found or no permissions provided');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function deleteRole(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string|exists:roles,name']);
            $role = Role::where('name', $validatedData['name'])->first();
            if ($role) {
                $roleId = $role->id;
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::transaction(function () use ($roleId) {
                    DB::table('role_has_permissions')->where('role_id', $roleId)->delete();
                    DB::table('model_has_roles')->where('role_id', $roleId)->delete();
                    DB::table('roles')->where('id', $roleId)->delete();
                });
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Role deleted successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'Role not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function addRole(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'name' => 'required|string|exists:roles,name'
            ]);
            $user = User::find($validatedData['user_id']);
            $role = Role::where('name', $validatedData['name'])->first();
            if ($user && $role) {
                $user->assignRole($role);
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Role assigned to user successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'User or Role not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function revokeRole(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'name' => 'required|string|exists:roles,name'
            ]);
            $user = User::find($validatedData['user_id']);
            $role = Role::where('name', $validatedData['name'])->first();
            if ($user && $role) {
                $user->removeRole($role);
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Role revoked from user successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'User or Role not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function createPermission(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string']);
            $permission = Permission::create(['name' => $validatedData['name'], 'guard_name' => 'web']);
            Cache::forget('dashboard');
            return redirect()->route('dashboard')->with('success', 'Permission created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function deletePermission(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string|exists:permissions,name']);
            $permission = Permission::where('name', $validatedData['name'])->first();
            if ($permission) {
                $permissionId = $permission->id;
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::transaction(function () use ($permissionId) {
                    DB::table('role_has_permissions')->where('permission_id', $permissionId)->delete();
                    DB::table('model_has_permissions')->where('permission_id', $permissionId)->delete();
                    DB::table('permissions')->where('id', $permissionId)->delete();
                });
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Permission deleted successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'Permission not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function addPermission(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'name' => 'required|string|exists:permissions,name'
            ]);
            $user = User::find($validatedData['user_id']);
            $permission = Permission::where('name', $validatedData['name'])->first();
            if ($user && $permission) {
                $user->givePermissionTo($permission);
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Permission assigned to user successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'User or Permission not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }

    public function revokePermission(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'name' => 'required|string|exists:permissions,name'
            ]);
            $user = User::find($validatedData['user_id']);
            if ($user && $user->hasPermissionTo($validatedData['name'])) {
                $permission = Permission::findByName($validatedData['name']);
                $user->revokePermissionTo($permission);
                Cache::forget('dashboard');
                return redirect()->route('dashboard')->with('success', 'Permission revoked from user successfully.');
            }
            return redirect()->route('dashboard')->with('error', 'User or Permission not found');
        }
        return redirect()->route('dashboard')->with('error', 'Access Forbidden');
    }
}
