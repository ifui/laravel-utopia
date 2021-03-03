<?php

namespace Modules\Article\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ArticleCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (Request::method()) {
            case 'POST':
                $rules = [
                    'title' => 'required|unique:article_categories|max:240',
                    'order' => 'integer',
                    'icon' => 'max:240',
                    'parent_id' => 'integer|exists:article_categories,id',
                ];
                break;

            case 'PUT':
                $id = Request::route('category');
                $rules = [
                    'title' => [Rule::unique('article_categories')->ignore($id), 'max:240'],
                    'order' => 'integer',
                    'icon' => 'max:240',
                    'parent_id' => 'integer|exists:article_categories,id',
                ];
                break;

            default:
                return [];
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
