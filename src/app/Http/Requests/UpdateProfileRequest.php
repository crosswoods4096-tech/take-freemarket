<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可はコントローラで済んでいる前提
    }

    public function rules()
    {
        return [
            'name'      => 'required|string|max:20',
            'postcode'  => 'required|string|max:8',
            'address'   => 'required|string',
            'building'  => 'nullable|string|max:255',
            'avatar'    => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => '名前を入力してください。',
            'name.max:20'        => '名前は20文字以内で入力してください',
            'postcode.required'  => '郵便番号を入力してください。',
            'postcode.max:8'     => '郵便番号は8桁以内で入力してください',
            'address.required'   => '住所を入力してください。',

        ];
    }
}
