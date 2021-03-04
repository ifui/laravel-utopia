<?php

namespace Modules\Article\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (Request::method()) {
            case 'GET':
                $rules = [];
                break;

            case 'DELETE':
                $rules = [
                    'delete_ids' => 'required|array',
                    'delete_ids.*' => 'required|integer|exists:articles,id|distinct',
                ];
                break;

            default:
                return [
                    'title' => 'required|min:1|max:240',
                    'article_category_id' => 'required|integer|exists:article_categories,id',
                    'description' => 'max:240',
                    // 'content' => '',
                    'thumbnail' => 'max:240',
                    'status' => [Rule::in([-2, -1, 0, 1])], // 发布状态 -2: 退回 -1: 草稿 0: 审核中 1: 发布
                    'order' => 'integer',
                ];
                break;
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
