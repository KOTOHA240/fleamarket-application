<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'icon' => 'nullable|image|mimes:jpeg,png|max:2048',
            'name' => 'required|string|max:20',
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'icon.image' => '画像ファイルを選択してください',
            'icon.mimes' => '画像は.jpegまたは.png形式でアップロードしてください',
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => 'ユーザー名は20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
