<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|min:8|max:20|regex:/^[!-~]+$/',
            'password_confirm' => ['required|same:password'],
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'パスワード',
            'password_confirm' => '確認パスワード',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ':attributeを入力してください。',
            'password.min' => ':attributeは8文字以上で入力してください。',
            'password.max' => ':attributeは20文字以内で入力してください。',
            'password.regex' => ':attributeは半角英数字と記号のみで入力してください。',
            'password_confirm.required' => ':attributeを入力してください。',
            'password_confirm.same' => 'パスワードと確認パスワードが一致していません。',
        ];
    }
}
