<?php

namespace Modules\Article\Http\Controllers\V1;

use Illuminate\Http\Response;
use Modules\Article\Entities\Models\TaggableTag;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\V1\TagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(TagRequest $request)
    {
        $model = TaggableTag::filter($request->all())->get();

        return $this->result($model);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(TagRequest $request)
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
        $model = new TaggableTag();

        $tag = $model->find($id);

        if (!isset($tag)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        $model = TaggableTag::findByName($tag->name)->article;

        return $this->result($model);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(TagRequest $request, $id)
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
