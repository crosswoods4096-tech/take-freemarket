@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/deals/address_update.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-6 py-10">

    <div class="address-card">

        <h1 class="address-title">住所の変更</h1>

        <form action="{{ route('deal.address.update', $product->id) }}" method="POST">
            @csrf

            <!-- 郵便番号 -->
            <div class="text-left">
                <label class="address-label">郵便番号</label>
                <input type="text" name="postal_code"
                    value="{{ old('postal_code', $user->postcode) }}"
                    class="form-input-large"
                    placeholder="例：123-4567">
            </div>

            <!-- 住所 -->
            <div class="text-left">
                <label class="address-label">住所</label>
                <textarea name="address"
                    class="form-textarea-large"
                    placeholder="例：東京都新宿区〇〇1-2-3">{{ old('address', $user->address) }}</textarea>
            </div>

            <!-- 建物名 -->
            <div class="text-left">
                <label class="address-label">建物名</label>
                <input type="text" name="building"
                    value="{{ old('building', $user->building) }}"
                    class="form-input-large"
                    placeholder="例：コーポ〇〇 101号室">
            </div>

            <!-- 更新ボタン -->
            <button type="submit" class="address-submit-btn">
                更新する
            </button>

        </form>

    </div>

</div>
@endsection