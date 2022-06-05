<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Models\AdminUser;
use App\QueryBuilder\AdminUserQuery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class AdminUserController extends Controller
{

    /**
     * 浏览管理员用户列表
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('onlySuperAdmin');

        $model = QueryBuilder::for(AdminUser::class)
            ->allowedFilters(AdminUserQuery::filter())
            ->allowedSorts(AdminUserQuery::sort())
            ->allowedIncludes(AdminUserQuery::include())
            ->paginate($request->input('pageSize'));

        return success($model);
    }


    /**
     * 添加一个管理员用户
     *
     * @param AdminUserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(AdminUserRequest $request)
    {
        $this->authorize('onlySuperAdmin');

        $model = new AdminUser();
        $model->fill($request->validated());
        $model['uuid'] = (string)Str::uuid();
        $model['password'] = $request->input('password');

        return resultStatus($model->save());
    }

    /**
     * 显示管理员用户的详细信息
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $model = QueryBuilder::for(AdminUser::class)
            ->allowedIncludes(AdminUserQuery::include())
            ->findOrFail($id);

        // 本人才可访问
        $this->authorize('isOwner', $model);

        return result($model);
    }

    /**
     * 更新管理员用户信息
     *
     * @param AdminUserRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(AdminUserRequest $request, int $id)
    {
        $model = AdminUser::findOrFail($id);

        // 本人才可访问
        $this->authorize('isOwner', $model);

        $model->fill($request->validated());

        // 只有超级管理员才可以更新管理员的密码
        if ($request->has('password')) {
            $this->authorize('onlySuperAdmin');
            $model['password'] = $request->input('password');
        }

        return resultStatus($model->save());
    }

    /**
     * 删除一个管理员账号
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id)
    {
        $this->authorize('onlySuperAdmin');

        $model = AdminUser::findOrFail($id);

        return resultStatus($model->delete());
    }
}
