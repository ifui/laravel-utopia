<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Article\Entities\Models\Article;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\Admin\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ArticleRequest $request)
    {
        $model = Article::with('user', 'category', 'tags')->filter($request->all())->paginateFilter();

        return $this->result($model);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $model = new Article();

        $model->fill($request->all());

        $user = Auth::user();

        $model->user_id = $user->id;
        $model->user_type = get_class($user);

        $model->save();

        // 添加标签
        if ($request->tags) {
            $model->retag($request->tags);
        }

        return $this->success();

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = Article::with('user', 'category', 'tags')->find($id);

        if (isset($data)) {
            return $this->success($data);
        } else {
            return $this->error();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param ArticleRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $model = Article::find($id);

        if (!isset($model)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        $model->fill($request->all());

        $model->save();

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $model = Article::find($id);

        if (!isset($model)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        if ($model->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Batch remove the specified resource from storage.
     * @param ArticleRequest $request
     * @return Response
     */
    public function batch(ArticleRequest $request)
    {
        $delete_ids = $request->delete_ids;

        if (Article::destroy($delete_ids)) {
            return $this->success();
        } else {
            return $this->error();
        }
    }
}
