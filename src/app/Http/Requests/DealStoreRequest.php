<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealStoreRequest extends FormRequest
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
    public function store(DealStoreRequest $request)
    {
        // まず送られてきた値を確認
        dd($request->all());

        // ここに購入処理を書く（後で実装）
    }

    public function rules()
    {

        return [
            'product_id' => ['required', 'integer'],
            'payment' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => '支払方法を選択してください。',
        ];
    }
}
