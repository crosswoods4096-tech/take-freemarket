<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'payment' => ['required'],
            'postcode' => ['required'],
            'address' => ['required'],
            'building' => ['string'],
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => '支払方法を選択してください。',
        ];
    }
}
