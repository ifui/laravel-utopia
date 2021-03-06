<?php

namespace Modules\Article\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Modules\Article\Entities\Models\TaggableTag;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table_name = TaggableTag::class;

        switch (Request::method()) {
            case 'POST':
                $rules = [
                    'name' => "required|unique:$table_name,name|max:240",
                    'normalized' => "unique:$table_name,normalized|max:240",
                ];
                break;

            case 'PUT':
                $id = Request::route('tag');
                if (!is_numeric($id)) {
                    throw new \InvalidArgumentException(__('Must be an integer'));
                }

                $rules = [
                    'name' => [Rule::unique($table_name, 'name')->ignore($id, 'tag_id'), 'max:240'],
                    'normalized' => [Rule::unique($table_name, 'normalized')->ignore($id, 'tag_id'), 'max:240'],
                ];
                break;

            case 'DELETE':
                $rules = [
                    'delete_ids' => 'required|array',
                    'delete_ids.*' => "required|integer|exists:$table_name,tag_id|distinct",
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
