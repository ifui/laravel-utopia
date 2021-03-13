<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
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
     * 简单返回状态信息 不返回任何参数
     *
     * @param boolean $boolean
     * @return \Illuminate\Http\Response
     */
    public static function resultStatus(bool $boolean = true)
    {
        if ((bool) $boolean) {
            return static::success();
        } else {
            return static::error();
        }
    }

    /**
     * 返回成功信息
     * 参考阿里
     *
     * @param array|string|integer $data 数据
     * @param int $successCode 状态码
     * @return \Illuminate\Http\Response
     */
    public static function success($data = null, int $successCode = 200): Response
    {
        $response = [
            'success' => true,
        ];

        if (isset($data)) {
            $response = array_merge($response, ['data' => $data]);
        }

        return Response($response, $successCode);
    }

    /**
     * 返回错误信息
     * 参考阿里
     *
     * @var string|array|int $errorMessage 错误信息
     * @param int $errorCode 状态码
     * @return \Illuminate\Http\Response
     */
    public static function error($errorMessage = null, int $errorCode = 400): Response
    {
        $response = [
            'success' => false,
            'errorCode' => $errorCode,
            'errorMessage' => $errorMessage ? $errorMessage : Lang::get(`code.$errorCode`),
        ];

        return Response($response, $errorCode);
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
        $user_id = $this->auth()->setToken($token)->user()->id;

        $user = AdminUser::with('roles')->find($user_id)->toArray();

        $token_response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 60,
        ];

        return $this->success(array_merge($user, $token_response), Lang::get('code.user_login_success'));
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
