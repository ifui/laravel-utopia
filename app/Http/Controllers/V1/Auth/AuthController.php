<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Guard;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

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

        if (!$token = Guard::api()->attempt([
            'username' => $username,
            'password' => $password,
        ])) {
            return $this->error(Lang::get('code.user_login_failed'));
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

        $user->username = $request['username'];
        $user->password = Hash::make($request['password']);

        if ($user->save()) {
            return $this->success();
        } else {
            return $this->error(Lang::get('code.user_register_failed'));
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
            Guard::api()->logout();
            return $this->success();
        } catch (\Exception $e) {
            return $this->error(Lang::get('code.user_login_failed'));
        }
    }

    /**
     * 刷新令牌
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $token = Guard::api()->refresh();

        return $this->respondWithToken($token);
    }
}
