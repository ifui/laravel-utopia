<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\PasswordEmailRequest;
use App\Http\Requests\Admin\Auth\PasswordUpdateRequest;
use App\Mail\PasswordMail;
use App\Models\AdminUser;
use App\Redis\AdminPasswordRedis;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    // 密码过期时间 10 * 60 秒
    protected $expires = 10 * 60;

    /**
     * 更新用户密码
     *
     * @param PasswordUpdateRequest $request
     * @return void
     */
    public function update(PasswordUpdateRequest $request)
    {
        try {
            $email = $request->email;
            $code = $request->code;
            $password = $request->password;

            // 检查验证码
            $redis_code = AdminPasswordRedis::get($email);
            if (!isset($redis_code)) {
                return $this->error(__('Verification code expired'));
            }
            if ($redis_code !== $code) {
                return $this->error(__('Invalid verification code'));
            }

            // 执行更新操作
            $user = new AdminUser();
            $user->where('email', $email);
            $user->password = $password;
            $user->update();

            // 删除 Redis 记录
            AdminPasswordRedis::del($email);

            return $this->success();

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 发送邮箱验证码
     *
     * @param PasswordEmailReuqest $request
     * @return void
     */
    public function email(PasswordEmailRequest $request)
    {
        try {
            $email = $request->email;
            // 随机生成一个验证码，并存入 Redis 中
            $code = random_int(10000, 999999);
            // 设置验证码
            AdminPasswordRedis::setex($email, $this->expires, $code);
            // 发送邮件
            Mail::to($email)->send(new PasswordMail($code));

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
