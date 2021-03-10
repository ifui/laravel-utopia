<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 配置用户认证 guard 参考 config/auth.php
    protected $guard = 'admin';

    /**
     * 创建实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }

    /**
     * 登录用户
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $loginForm = [
            'password' => $request->password,
        ];

        $request->email ? $loginForm = array_merge($loginForm, ['email' => $request->email]) : null;
        $request->username ? $loginForm = array_merge($loginForm, ['username' => $request->username]) : null;

        if (!$token = $this->auth()->attempt($loginForm)) {
            return $this->error(Lang::get('code.user_login_failed'));
        }
        return $this->respondWithToken($token);
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        try {
            $this->auth()->logout();
            return $this->success();
        } catch (\Exception $e) {
            return $this->error(Lang::get('code.user_login_failed'));
        }
    }

    /**
     * 注册用户
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new AdminUser();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nickname = $request->nickname;

        // 自动生成用户头像
        if (isset($request['avatar'])) {
            $user->avatar = $request->avatar;
        } else {
            $user->avatar = $request->nickname ? $this->create_avatar($request->nickname) : $this->create_avatar($request->email);
        }
        // 自动生成 uuid
        $user->uuid = (string) Str::uuid();

        if ($user->save()) {
            return $this->success();
        } else {
            return $this->error(Lang::get('code.user_register_failed'));
        }
    }

    /**
     * 刷新令牌
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $token = $this->auth()->refresh();

        return $this->respondWithToken($token);
    }
}
