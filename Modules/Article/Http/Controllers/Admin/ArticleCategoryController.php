<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Article\Entities\Models\ArticleCategory;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\Admin\ArticleCategoryRequest;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ArticleCategoryRequest $request)
    {
        $data = ArticleCategory::filter($request->all())->defaultOrder()->get()->toTree();

        return $this->result($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ArticleCategoryRequest $request)
    {
        $model = new ArticleCategory();

        $model->fill($request->all());

        if ($model->save()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = ArticleCategory::defaultOrder()->descendantsAndSelf($id)->toTree();

        return $this->result($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ArticleCategoryRequest $request, $id)
    {
        $model = ArticleCategory::find($id);

        $model->fill($request->all());

        if ($model->save()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // IMPORTANT! Any descendant that node has will also be deleted!
        // 将会删除节点所属节点，请谨慎操作
        $model = ArticleCategory::find($id);

        if (!isset($model)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        if ($model->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }
}
