<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 定义 Token 标识名
    protected string $tokenName = 'admin-login-token';

    /**
     * 用户注册
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $admin_user = new AdminUser();

        $admin_user['uuid'] = (string)Str::uuid();
        $admin_user['password'] = $request->input('password');
        $admin_user->fill($request->validated());

        return resultStatus($admin_user->save());
    }

    /**
     * 用户登录
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $admin_user = AdminUser::with(['roles', 'permissions'])
            ->where('username', $request->input('username'))
            ->first();

        if (!Hash::check($request->input('password'), $admin_user->password)) {
            throw ValidationException::withMessages([
                'password' => [__('auth.password')],
            ]);
        }

        // 认证用户实例
        if (!auth('admin')->attempt($request->validated())) {
            return error('code.10424');
        }

        // 创建新令牌前，删除旧登录令牌
        $admin_user->tokens()->where('name', $this->tokenName)->delete();

        return $this->respondWithToken($admin_user, $this->tokenName);
    }

    /**
     * 刷新登录令牌
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request)
    {
        $admin_user = AdminUser::with(['roles', 'permissions'])->find($request->user()->id);

        return $this->respondWithToken($admin_user, $this->tokenName);
    }

    /**
     * 用户登出
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        // 撤销所有登录过的令牌
        $request->user()->tokens()->where('name', $this->tokenName)->delete();

        auth('admin')->logout();

        return success();
    }

    /**
     * 登录用户信息
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userinfo(Request $request)
    {
        $user_id = $request->user()->id;

        $admin_user = AdminUser::with(['roles', 'permissions'])->find($user_id);

        if (!$admin_user) {
            return error('code.10401');
        }

        return success($admin_user);
    }
}
