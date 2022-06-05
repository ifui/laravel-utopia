<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 测试后台用户注册、登录、刷新令牌、登出等功能
     *
     * @return void
     */
    public function test_login()
    {
        // 测试账号用户信息
        $username = 'ifui';
        $password = '123456';

        // 注册账号
        $response = $this->post(route('admin.register'), [
            'username' => $username,
            'password' => $password,
        ]);
        $response->assertJson([
            'success' => true
        ]);

        // 错误密码登录应当失败
        $response = $this->post(route('admin.login'), [
            'username' => $username,
            'password' => '2222'
        ]);
        $response->assertJson([
            'success' => false
        ]);

        // 登录应当成功
        $response = $this->post(route('admin.login'), [
            'username' => $username,
            'password' => $password
        ]);
        $response->assertJson([
            'success' => true
        ]);

        // 刷新令牌
        $response = $this->get(route('admin.refresh'));
        $response->assertJson([
            'success' => true,
        ]);

        // 获取登录用户信息
        $response = $this->get(route('admin.userinfo'));
        $response->assertJson([
            'success' => true,
        ]);

        $response = $this->get(route('admin.logout'));
        $response->assertJson([
            'success' => true,
        ]);
    }
}
