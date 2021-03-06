<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Article\Entities\Models\TaggableTag;
use Modules\Article\Entities\Models\TaggableTaggable;
use Modules\Article\Http\Controllers\Controller;
use Modules\Article\Http\Requests\Admin\TagRequest;

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
        $model = new TaggableTag();

        $model->name = $request->name;
        $model->normalized = isset($request->normalized) ? $request->normalized : $request->name;

        return $this->resultStatus($model->save());
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
        $model = TaggableTag::find($id);

        if (!isset($model)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        $model->fill($request->all());

        return $this->resultStatus($model->save());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $model = new TaggableTag();

        $tag = $model->find($id);

        if (!isset($tag)) {
            return $this->error(__('article::lang.The resource was not found'));
        }

        $tagable = TaggableTaggable::where('tag_id', $tag->tag_id)->delete();
        $tagStatus = $tag->delete();

        return $this->resultStatus($tagable || $tagStatus);
    }

    /**
     * Batch remove the specified resource from storage.
     * @param ArticleRequest $request
     * @return Response
     */
    public function batch(TagRequest $request)
    {
        $delete_ids = $request->delete_ids;

        $tagStatus = TaggableTag::destroy($delete_ids);
        $tagable = TaggableTaggable::destroy($delete_ids, 'tag_id');

        return $this->resultStatus($tagable || $tagStatus);
    }
}
