<?php

namespace App\Http\Requests\Admin;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'min:1|max:16',
            'password' => 'required|min:5|max:20',
            'username' => 'required|min:2|max:20',
            'phone' => [new Phone(), 'unique:admin_users,phone'],
            'email' => 'email|unique:admin_users,email',
            'avatar' => 'string',
        ];
    }
}
