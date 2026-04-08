<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:5120'], // 5MB
            'categories' => ['required', 'string'], // "1,3,5" のような文字列
            'condition' => ['required', 'in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い'],
            'name' => ['required', 'string', 'max:50'],
            'brand' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:500'],
            'price' => ['required', 'integer', 'min:300', 'max:999999'],
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
            'description.max' => '商品の説明は500文字以内で入力してください。',

            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は300円以上で入力してください。',
            'price.max' => '販売価格は999,999円以内で入力してください。',
        ];
    }
}
