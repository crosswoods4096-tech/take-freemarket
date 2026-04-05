@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">

    <!-- 2カラム全体 -->
    <div class="grid grid-cols-3 gap-8">

        <!-- 左側（2/3） -->
        <div class="col-span-2">

            <!-- 商品画像 + 商品名 + 価格 -->
            <div class="flex items-start gap-6">

                <!-- 商品画像 -->
                <img src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="w-64 h-64 object-cover rounded-lg shadow">

                <!-- 商品名 + 価格 -->
                <div>
                    <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                    <p class="text-xl font-semibold text-gray-700 mt-2">
                        ¥{{ number_format($product->price) }}
                    </p>
                </div>

            </div>

            <!-- 下線 -->
            <hr class="my-6 border-gray-300">

            <!-- 支払方法 -->
            <h2 class="text-lg font-bold mb-3">支払方法</h2>

            <select id="paymentSelect" name="payment" class="w-60 border border-gray-300 rounded-lg p-2">
                <option value="コンビニ払い">コンビニ払い</option>
                <option value="カード支払い">カード支払い</option>
            </select>
            <!-- 下線 -->
            <hr class="my-6 border-gray-300">

            <!-- 配送先 -->
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold">配送先</h2>
                <a href="#" class="text-blue-600 underline">変更する</a>
            </div>

            <div class="text-gray-700 leading-relaxed">
                <p>〒{{ $user->postal_code }}</p>
                <p>{{ $user->address }}</p>
                <p>{{ $user->building }}</p>
            </div>

        </div>

        <!-- 右側（1/3） -->
        <div class="col-span-1 space-y-6">

            <!-- 商品代金 -->
            <div class="border rounded-lg p-4 shadow-sm bg-white">
                <p class="text-sm text-gray-500">商品代金</p>
                <p class="text-xl font-bold mt-1">
                    ¥{{ number_format($product->price) }}
                </p>
            </div>

            <!-- 支払方法（右側表示用） -->
            <div class="border rounded-lg p-4 shadow-sm bg-white">
                <p class="text-sm text-gray-500">支払方法</p>
                <p id="paymentDisplay" class="text-lg font-semibold mt-1">
                    コンビニ払い
                </p>
            </div>

            <!-- 購入ボタン -->
            <form action="{{ route('deal.store') }}" method="POST">
                @csrf

                <!-- 支払方法を hidden で送る（JSで更新） -->
                <input type="hidden" name="payment" id="paymentInput" value="コンビニ払い">

                <button class="w-full bg-red-500 text-white py-3 rounded-lg text-lg font-bold hover:bg-red-600 transition">
                    購入する
                </button>
            </form>

        </div>

    </div>

</div>
<!-- ▼ JavaScript ▼ -->
<script>
    const paymentSelect = document.getElementById('paymentSelect');
    const paymentDisplay = document.getElementById('paymentDisplay');
    const paymentInput = document.getElementById('paymentInput');

    paymentSelect.addEventListener('change', function() {
        paymentDisplay.textContent = this.value;
        paymentInput.value = this.value; // ← 送信用 hidden に反映
    });
</script>
@endsection