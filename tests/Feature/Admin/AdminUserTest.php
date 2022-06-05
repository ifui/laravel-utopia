<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\AdminUserTraits;

class AdminUserTest extends TestCase
{
    use RefreshDatabase, AdminUserTraits;

    /**
     * 测试超级管理员操作管理员用户
     * 应当成功
     *
     * @return void
     */
    public function test_authorized()
    {
        $this->superAdminLogin();
        $superAdmin = AdminUser::where('username', 'ifui')->first();

        // 获取管理员列表
        $response = $this->get('/admin/admin_users');
        $response->assertJson([
            'success' => true
        ]);

        // 获取详细信息
        $response = $this->get('/admin/admin_users/' . $superAdmin->id);
        $response->assertJson([
            'success' => true
        ]);

        // 更新信息
        $response = $this->put('/admin/admin_users/' . $superAdmin->id, [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertJson([
            'success' => true
        ]);

        // 创建管理员
        $response = $this->post('/admin/admin_users', [
            'username' => 'test_admin',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertJson([
            'success' => true
        ]);
        $this->assertDatabaseHas(AdminUser::class, ['username' => 'test_admin']);

        // 删除管理员
        $test_admin = AdminUser::where('username', 'test_admin')->first();
        $response = $this->delete('/admin/admin_users/' . $test_admin->id);
        $response->assertJson([
            'success' => true
        ]);
        $this->assertDatabaseMissing(AdminUser::class, ['username' => 'test_admin']);
    }

    /**
     * 测试普通管理员用户操作管理员用户
     * 应当失败
     *
     * @return void
     */
    public function test_unauthorized()
    {
        $this->adminLogin();
        $superAdmin = AdminUser::where('username', 'ifui')->first();

        $response = $this->get('/admin/admin_users');
        $response->assertJson([
            'success' => false,
            'code' => 'code.10403'
        ]);

        $response = $this->get('/admin/admin_users/' . $superAdmin->id);
        $response->assertJson([
            'success' => false,
            'code' => 'code.10403'
        ]);

        $response = $this->put('/admin/admin_users/' . $superAdmin->id, [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertJson([
            'success' => false,
            'code' => 'code.10403'
        ]);

        $response = $this->post('/admin/admin_users', [
            'username' => 'test_admin',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertJson([
            'success' => false,
            'code' => 'code.10403'
        ]);

        $response = $this->delete('/admin/admin_users/' . $superAdmin->id);
        $response->assertJson([
            'success' => false,
            'code' => 'code.10403'
        ]);
    }
}
