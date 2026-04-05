@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">

    <!-- 全体を中央寄せ -->
    <div class="max-w-md mx-auto text-center">

        <!-- タイトル -->
        <h1 class="text-2xl font-bold mb-8">住所の変更</h1>

        <!-- フォーム -->
        <form action="{{ route('address.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 郵便番号 -->
            <div>
                <label class="block text-left font-semibold mb-1">郵便番号</label>
                <input type="text" name="postal_code"
                    value="{{ old('postal_code', $user->postal_code) }}"
                    class="w-full border border-gray-300 rounded-lg p-3"
                    placeholder="例：123-4567">
            </div>

            <!-- 住所 -->
            <div>
                <label class="block text-left font-semibold mb-1">住所</label>
                <input type="text" name="address"
                    value="{{ old('address', $user->address) }}"
                    class="w-full border border-gray-300 rounded-lg p-3"
                    placeholder="例：東京都新宿区〇〇1-2-3">
            </div>

            <!-- 建物名 -->
            <div>
                <label class="block text-left font-semibold mb-1">建物名</label>
                <input type="text" name="building"
                    value="{{ old('building', $user->building) }}"
                    class="w-full border border-gray-300 rounded-lg p-3"
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