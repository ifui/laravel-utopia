<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'admin', 'name' => 'edit articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'delete articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'admin', 'name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['guard_name' => 'admin', 'name' => 'super-admin']);

        // create demo users

        $user = \App\Models\AdminUser::factory()->create([
            'nickname' => 'Example Super-Admin User',
            'email' => 'ifui@foxmail.com',
        ]);
        $user->assignRole($role3);

        $user = \App\Models\AdminUser::factory()->create([
            'nickname' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\AdminUser::factory()->create([
            'nickname' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role1);
    }
}
