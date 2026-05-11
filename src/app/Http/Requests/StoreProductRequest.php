<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:5120'], // ← nullable に変更
            'categories' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'name' => ['required', 'string', 'max:50'],
            'brand' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0', 'max:999999'],
        ];
    }


    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',
            'image.max' => '画像サイズは5MB以内にしてください。',

            'categories.required' => 'カテゴリを選択してください。',

            'condition.required' => '商品の状態を選択してください。',
            'condition.in' => '選択された商品の状態が不正です。',

            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は50文字以内で入力してください。',

            'brand.max' => 'ブランド名は50文字以内で入力してください。',

            'description.required' => '商品の説明を入力してください。',
            'description.max' => '商品の説明は255文字以内で入力してください。',

            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
            'price.max' => '販売価格は1,000,000円未満で入力してください。',
        ];
    }
}
