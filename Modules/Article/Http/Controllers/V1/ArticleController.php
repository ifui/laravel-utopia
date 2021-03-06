<?php

namespace Modules\Article\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Article\Entities\Models\Article;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\V1\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ArticleRequest $request)
    {
        $model = Article::with('user:id,email,nickname', 'category', 'tags')->filter($request->all())->paginateFilter();

        return $this->result($model);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
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
        $data = Article::with('user:id,email,nickname', 'category', 'tags')->find($id);

        return $this->result($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
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
