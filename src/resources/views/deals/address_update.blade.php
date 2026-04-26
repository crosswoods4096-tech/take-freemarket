@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">

    <div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow text-center">

        <h1 class="text-2xl font-bold mb-8">住所の変更</h1>

        <form action="{{ route('deal.address.update', $product->id) }}" method="POST">


            @csrf

            <!-- 郵便番号 -->
            <div class="text-left">
                <label class="block font-semibold mb-1">郵便番号</label>
                <input type="text" name="postal_code"
                    value="{{ old('postal_code', $user->postcode) }}"
                    class="form-input-large"
                    placeholder="例：123-4567">
            </div>

            <!-- 住所（大きめ） -->
            <div class="text-left">
                <label class="block font-semibold mb-1">住所</label>
                <textarea name="address"
                    class="form-textarea-large"
                    placeholder="例：東京都新宿区〇〇1-2-3">{{ old('address', $user->address) }}</textarea>
            </div>

            <!-- 建物名 -->
            <div class="text-left">
                <label class="block font-semibold mb-1">建物名</label>
                <input type="text" name="building"
                    value="{{ old('building', $user->building) }}"
                    class="form-input-large"
                    placeholder="例：コーポ〇〇 101号室">
            </div>

            <!-- 更新ボタン -->
            <button type="submit"
                class="w-full bg-[#FF5555] text-white py-3 rounded-lg text-lg font-bold hover:bg-red-600 transition">
                更新する
            </button>

        </form>

    </div>

</div>
@endsection