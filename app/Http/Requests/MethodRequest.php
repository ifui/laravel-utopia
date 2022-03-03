<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class MethodRequest extends FormRequest
{
    // 默认公用规则
    protected $defaultRules = [];

    /**
     * 重写 rules 方法，根据请求方法调用相关函数
     * 比如: GET -> getRules()
     *
     * @return array
     */
    public function rules()
    {
        // 转小写方法
        $method = strtolower(Request::method()) . 'Rules';

        if (method_exists($this, $method)) {
            $rules = $this->$method();
        } else {
            $rules = [];
        }

        return $rules + $this->defaultRules;
    }

    /**
     * 重写权限验证方法
     * 比如： postAuthorize
     *
     * @return bool
     */
    public function authorize()
    {
        $method = strtolower(Request::method()) . 'Authorize';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return true;
    }
}
