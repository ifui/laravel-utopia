<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 生成 Token
     *
     * @param mixed $user
     * @param string $tokenName
     * @return JsonResponse
     */
    public function respondWithToken(mixed $user, string $tokenName)
    {
        $token = $user->createToken($tokenName)->plainTextToken;

        if (isset($token)) {
            return success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration'),
                'userinfo' => $user
            ]);
        } else {
            return error('code.10424');
        }
    }
}
