<?php

namespace App\Http\Requests\V1\Auth;

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
            'username' => 'required|min:1|max:16|unique:users',
            'truename' => 'min:1|max:16',
            'password' => 'required|min:5|max:20',
            'email' => 'email',
            'avatar' => 'string',
        ];
    }
}
