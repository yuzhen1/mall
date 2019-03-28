<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginValidate extends FormRequest
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
            'user_name' => [
                'required',
                'max:255',
                'regex:/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('users')->ignore(request()->user_id,'user_id')
            ],
            'user_pwd' => 'sometimes|required|max:12|min:6|alpha_dash',
            'repwd'=>'required'
        ];
    }
    /** 提示信息 */
    public function messages(){
        return [
            'user_name.required' => '邮箱不能为空',
            'user_name.unique' => '邮箱已存在',
            'user_pwd.required' => '密码不能为空',
            'repwd.required' => '确认密码不能为空'
        ];
    }
}
