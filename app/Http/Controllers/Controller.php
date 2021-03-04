<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // 配置用户认证 guard 参考 config/auth.php
    protected $guard = 'api';

    /**
     * 自动返回信息
     *
     * @param any $data
     * @return \Illuminate\Http\Response
     */
    public static function result($data = null)
    {
        if (isset($data)) {
            return static::success($data);
        } else {
            return static::error();
        }
    }

    /**
     * 返回成功信息
     *
     * @param array|string|integer $data 数据
     * @param string $message 提示信息
     * @param int $status 状态码
     * @return \Illuminate\Http\Response
     */
    public static function success($data = null, string $message = null): Response
    {
        if (!isset($message)) {
            $message = Lang::get('code.success');
        }

        $response = [
            'status' => true,
            'message' => $message,
        ];

        if (isset($data)) {
            $response = array_merge($response, ['data' => $data]);
        }

        return Response($response, 200);
    }

    /**
     * 返回错误信息
     *
     * @param string $message 提示信息
     * @param int $status 状态码
     * @param string $errors 详细错误信息
     * @return \Illuminate\Http\Response
     */
    public static function error(string $message = null, $errors = null): Response
    {
        if (!isset($message)) {
            $message = Lang::get('code.error');
        }

        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (isset($errors)) {
            $response = array_merge($response, ['errors' => $errors]);
        }

        return Response($response, 400);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): Response
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 60,
        ], Lang::get('code.user_login_success'));
    }

    /**
     * 生成头像
     *
     * @param string $username 用户名
     * @param integer $id ID
     * @return void
     */
    public static function create_avatar(string $username)
    {
        // 头像保存路径
        $avatar_path = 'images/avatars/' . md5(time()) . '.png';
        // 头像保存完整路径
        $avatar_save_path = storage_path('app/public/') . $avatar_path;
        Avatar::create($username)->save($avatar_save_path);
        // 返回头像 URL
        return Storage::url($avatar_path);
    }

    /**
     * 返回 api 认证守卫
     *
     * @return @var \Illuminate\Support\Facades\Auth $auth
     */
    public function auth()
    {
        return Auth::guard($this->guard);
    }
}
