<?php

namespace Tests\Traits;

use App\Models\AdminUser;
use Database\Seeders\SuperAdminInitSeeder;

trait AdminUserTraits
{
    /**
     * 普通管理员用户登录
     *
     * @param AdminUser|null $admin_user
     * @return AdminUser
     */
    private function adminLogin(AdminUser $admin_user = null)
    {
        $this->seed(SuperAdminInitSeeder::class);

        if (!$admin_user) {
            $admin_user = AdminUser::factory()->create([
                'username' => 'test_admin',
                'password' => '123456',
                'status' => 1
            ]);
        }

        // 后台用户登录（具有权限）
        $response = $this->postJson('/admin/login', [
            'username' => $admin_user->username,
            'password' => '123456'
        ]);
        $response->assertJson([
            'success' => true
        ]);

        return AdminUser::where('username', $admin_user->username)->first();
    }

    /**
     * 超级管理员用户登录
     *
     * @return AdminUser
     */
    private function superAdminLogin()
    {
        $this->seed(SuperAdminInitSeeder::class);

        // 后台用户登录（具有权限）
        $response = $this->postJson('/admin/login', [
            'username' => 'ifui',
            'password' => 'admin'
        ]);
        $response->assertJson([
            'success' => true
        ]);

        return AdminUser::where('username', 'ifui')->first();
    }
}
