<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function dashboard(Request $request): Response | View
    {
        if (!$request->user()->canAccessDashboard()) {
            return response()->json(['message' => 'You do not have access to the dashboard.'], Response::HTTP_FORBIDDEN);
        }

        $users = User::with(['roles.permissions', 'permissions'])->get();
        $roles = Role::all()->pluck('name');
        $rolesWithAssociatedPermissions = Role::with('permissions')->get();
        $permissions = Permission::all()->pluck('name');

        return view('dashboard.index', compact('users', 'roles', 'rolesWithAssociatedPermissions', 'permissions'));
    }

    public function createRole(Request $request): Response
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string']);
            $role = Role::create(['name' => $validatedData['name'], 'guard_name' => 'web']);
            return response()->json($role, Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function updateRole(Request $request): Response
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
                $role->syncPermissions($permissions);
                return response()->json([
                    'message' => 'Role permissions updated successfully',
                    'role' => $role
                ]);
            }
            return response()->json(['message' => 'Role not found or no permissions provided'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function deleteRole(Request $request): Response
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string|exists:roles,name']);
            $role = Role::where('name', $validatedData['name'])->first();
            if ($role) {
                $role->delete();
                return response()->json(['message' => 'Role deleted successfully'], Response::HTTP_NO_CONTENT);
            }
            return response()->json(['message' => 'Role not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function addRole(Request $request): Response
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
                return response()->json(['message' => 'Role assigned to user successfully'], Response::HTTP_OK);
            }
            return response()->json(['message' => 'User or Role not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function revokeRole(Request $request): Response
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
                return response()->json(['message' => 'Role revoked from user successfully'], Response::HTTP_OK);
            }
            return response()->json(['message' => 'User or Role not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function createPermission(Request $request): Response
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string']);
            $permission = Permission::create(['name' => $validatedData['name'], 'guard_name' => 'web']);
            return response()->json($permission, Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function deletePermission(Request $request): Response
    {
        if ($request->user()->isAdmin()) {
            $validatedData = $request->validate(['name' => 'required|string|exists:permissions,name']);
            $permission = Permission::where('name', $validatedData['name'])->first();
            if ($permission) {
                $permission->delete();
                return response()->json(['message' => 'Permission deleted successfully'], Response::HTTP_NO_CONTENT);
            }
            return response()->json(['message' => 'Permission not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function addPermission(Request $request): Response
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
                return response()->json(['message' => 'Permission assigned to user successfully'], Response::HTTP_OK);
            }
            return response()->json(['message' => 'User or Permission not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    public function revokePermission(Request $request): Response
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
                return response()->json(['message' => 'Permission revoked from user successfully'], Response::HTTP_OK);
            }
            return response()->json(['message' => 'User or Permission not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }
}
