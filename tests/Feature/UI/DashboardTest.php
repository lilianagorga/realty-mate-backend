<?php

namespace Tests\Feature\UI;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_admin_can_view_roles_and_permissions(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/dashboard/roles-and-permissions');

        $response->assertStatus(200);
        $response->assertViewHas('roles');
        $response->assertViewHas('permissions');
    }

    public function test_non_admin_cannot_view_roles_and_permissions(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/roles-and-permissions');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'You do not have access to this section.');
    }

    public function test_admin_can_create_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post('/roles', [
            'name' => 'new-role',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Role created successfully.');
        $this->assertDatabaseHas('roles', ['name' => 'new-role']);
    }

    public function test_admin_can_update_role_permissions(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $role = Role::create(['name' => 'new-role', 'guard_name' => 'web']);
        Permission::create(['name' => 'new-permission', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->put('/roles', [
            'name' => 'new-role',
            'permissions' => ['new-permission'],
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Role permissions updated successfully.');
        $this->assertTrue($role->hasPermissionTo('new-permission'));
    }

    public function test_admin_can_delete_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $role = Role::create(['name' => 'delete-role', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->delete('/roles/delete', [
            'name' => 'delete-role',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Role deleted successfully.');
        $this->assertDatabaseMissing('roles', ['name' => 'delete-role']);
    }

    public function test_admin_can_assign_role_to_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $role = Role::create(['name' => 'assign-role', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->post('/roles/assign', [
            'user_id' => $user->id,
            'name' => 'assign-role',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Role assigned to user successfully.');
        $this->assertTrue($user->hasRole('assign-role'));
    }

    public function test_admin_can_revoke_role_from_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $role = Role::create(['name' => 'revoke-role', 'guard_name' => 'web']);
        $user->assignRole($role);

        $response = $this->actingAs($admin)->post('/roles/revoke', [
            'user_id' => $user->id,
            'name' => 'revoke-role',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Role revoked from user successfully.');
        $this->assertFalse($user->hasRole('revoke-role'));
    }

    public function test_admin_can_create_permission(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post('/permissions', [
            'name' => 'new-permission',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Permission created successfully.');
        $this->assertDatabaseHas('permissions', ['name' => 'new-permission']);
    }

    public function test_admin_can_delete_permission(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $permission = Permission::create(['name' => 'delete-permission', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->delete('/permissions/delete', [
            'name' => 'delete-permission',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Permission deleted successfully.');
        $this->assertDatabaseMissing('permissions', ['name' => 'delete-permission']);
    }

    public function test_admin_can_assign_permission_to_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'assign-permission', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->post('/permissions/assign', [
            'user_id' => $user->id,
            'name' => 'assign-permission',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Permission assigned to user successfully.');
        $this->assertTrue($user->hasPermissionTo('assign-permission'));
    }

    public function test_admin_can_revoke_permission_from_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'revoke-permission', 'guard_name' => 'web']);
        $user->givePermissionTo($permission);

        $response = $this->actingAs($admin)->post('/permissions/revoke', [
            'user_id' => $user->id,
            'name' => 'revoke-permission',
        ]);

        $response->assertRedirect('/dashboard/roles-and-permissions');
        $response->assertSessionHas('success', 'Permission revoked from user successfully.');
        $this->assertFalse($user->hasPermissionTo('revoke-permission'));
    }
}
