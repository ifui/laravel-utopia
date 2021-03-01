<?php

namespace App\Http\Controllers\Admin\AUth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\UserRequest;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AdminUser::with('roles')->find(Auth::user()->id)->toArray();

        return $this->success($data);
    }

    /**
     * 更新用户信息
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        // 只允许账号本人修改本人信息
        $userid = Auth::user()->id;

        $model = new AdminUser();
        $model = $model->find($userid);
        $model->fill($request->all());
        $model->save();

        return $this->success();
    }
}
