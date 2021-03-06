<?php

namespace Modules\Article\Http\Controllers\V1;

use Illuminate\Http\Response;
use Modules\Article\Entities\Models\Article;
use Modules\Article\Entities\Models\ArticleCategory;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\V1\ArticleCategoryRequest;

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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $model = ArticleCategory::find($id);

        if (!isset($model)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        $data = Article::where('article_category_id', $id)->get();

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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
