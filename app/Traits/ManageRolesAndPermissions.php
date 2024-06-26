<?php

namespace App\Traits;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait ManageRolesAndPermissions
{
    public function setupRolesAndPermissions(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $teamRole = Role::findOrCreate('team', 'web');

        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');
        $managePropertiesPermission = Permission::findOrCreate('manageProperties', 'web');
        $teamManagementPermission = Permission::findOrCreate('teamManagement', 'web');
        $priceManagementPermission = Permission::findOrCreate('priceManagement', 'web');

        $adminRole->givePermissionTo($dashboardPermission);
        $adminRole->givePermissionTo($managePropertiesPermission);
        $adminRole->givePermissionTo($teamManagementPermission);
        $adminRole->givePermissionTo($priceManagementPermission);

        $teamRole->givePermissionTo($dashboardPermission);
        $teamRole->givePermissionTo($managePropertiesPermission);
    }
}
