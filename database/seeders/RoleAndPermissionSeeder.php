<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'access-admin',
            'manage-settings',
            'manage-users',
            'manage-phases',
            'manage-events',
            'manage-speakers',
            'manage-testimonials',
            'manage-posts',
            'manage-categories',
            'view-messages',
            'manage-messages',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create roles and assign existing permissions
        $superAdmin = Role::findOrCreate('super-admin');
        // Super Admin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        $editor = Role::findOrCreate('editor');
        $editor->givePermissionTo([
            'access-admin',
            'manage-phases',
            'manage-events',
            'manage-speakers',
            'manage-testimonials',
            'manage-posts',
            'manage-categories',
            'view-messages',
        ]);

        $contentWriter = Role::findOrCreate('content-writer');
        $contentWriter->givePermissionTo([
            'access-admin',
            'manage-posts',
            'manage-categories',
        ]);
    }
}
