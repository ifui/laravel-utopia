<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\PasswordEmailReuqest;
use App\Http\Requests\V1\Auth\PasswordUpdateRequest;
use App\Mail\PasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

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
            $redis_code = Redis::get('password:' . $email);
            if (!isset($redis_code)) {
                return $this->error(__('Verification code expired'));
            }
            if ($redis_code !== $code) {
                return $this->error(__('Invalid verification code'));
            }

            // 执行更新操作
            $user = new User();
            $user->where('email', $email);
            $user->password = $password;
            $user->update();

            // 删除 Redis 记录
            Redis::del('password:' . $email);

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
    public function email(PasswordEmailReuqest $request)
    {
        try {
            $email = $request->email;
            // 随机生成一个验证码，并存入 Redis 中
            $code = random_int(10000, 999999);
            // 设置验证码
            Redis::setex('password:' . $email, $this->expires, $code);
            // 发送邮件
            Mail::to($email)->send(new PasswordMail($code));

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
