<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * 创建实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * 登录用户
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;

        if (!$token = $this->auth()->attempt([
            'username' => $username,
            'password' => $password,
        ])) {
            return $this->error(__('error.user_login_failed'), 422);
        }
        return $this->respondWithToken($token);
    }

    /**
     * 注册用户
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();

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
            return $this->error(__('error.user_register_failed'), 422);
        }
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
            return $this->error(__('error.user_login_failed'));
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
