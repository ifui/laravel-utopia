<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminInitSeeder extends Seeder
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

        // 创建超级管理员角色
        $role = Role::updateOrCreate(
            [
                'guard_name' => 'admin',
                'name' => 'super-admin',
            ],
            [
                'guard_name' => 'admin',
                'name' => 'super-admin',
                'description' => '超级管理员角色'
            ]
        );

        // 创建超级管理员权限
        $permission = Permission::updateOrCreate(
            [
                'guard_name' => 'admin',
                'name' => 'administrator',
            ],
            [
                'guard_name' => 'admin',
                'name' => 'administrator',
                'description' => '拥有站点全部权限'
            ]
        );

        // 给角色分配权限
        $role->givePermissionTo($permission);

        $super_user = AdminUser::updateOrCreate(
            [
                'username' => 'ifui',
            ],
            [
                'uuid' => (string)Str::uuid(),
                'username' => 'ifui',
                'nickname' => '超级管理员',
                'password' => 'admin',
                'email' => 'ifui@foxmail.com',
            ]
        );

        $super_user->syncRoles($role);
        $super_user->syncPermissions($permission);

        $super_user2 = AdminUser::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'uuid' => (string)Str::uuid(),
                'username' => 'admin',
                'nickname' => '超级管理员',
                'password' => 'admin',
                'email' => 'admin@example.com',
            ]
        );

        $super_user2->syncRoles($role);
        $super_user2->syncPermissions($permission);
    }
}
