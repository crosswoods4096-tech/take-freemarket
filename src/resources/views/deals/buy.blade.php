@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/deals/buy.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-6 py-8 buy-container flex gap-10 relative">

    <!-- 左側（2/3） -->
    <div class="flex-1 relative z-0">

        <!-- 商品画像 + 商品名 + 価格 -->
        <div class="flex items-start gap-6">

            <!-- 商品画像 -->
            <img src="{{ $product->image_url }}" class="buy-image shadow">

            <!-- 商品名 + 価格 -->
            <div>
                <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                <p class="text-xl font-semibold text-gray-700 mt-2">
                    ¥{{ number_format($product->price) }}
                </p>
            </div>

        </div>

        <hr class="my-6 border-gray-300">

        <!-- 支払方法（左側表示用） -->
        <h2 class="text-lg font-bold mb-3">支払方法</h2>

        <select id="paymentSelect" name="payment" class="w-60 border border-gray-300 rounded-lg p-2">
            <option value="" selected disabled>選択してください</option>
            <option value="コンビニ払い">コンビニ払い</option>
            <option value="カード支払い">カード支払い</option>
        </select>

        <hr class="my-6 border-gray-300">

        <!-- 配送先 -->
        <div class="buy-address-header mb-3">
            <h2 class="text-lg font-bold">配送先</h2>
            <a href="{{ route('deal.address.edit', $product->id) }}" class="text-blue-600 underline">変更する</a>

        </div>

        <div class="text-gray-700 leading-relaxed">
            <p>〒{{ $user->postcode }}</p>
            <p>{{ $user->address }}</p>
            <p>{{ $user->building }}</p>
        </div>

    </div>

    <!-- 右側（1/3） -->
    <div class="w-1/3 space-y-6 relative z-10">

        <!-- 商品代金 -->
        <div class="buy-card flex justify-between items-center">
            <p class="buy-card-title">商品代金</p>
            <p class="buy-card-value">
                ¥{{ number_format($product->price) }}
            </p>
        </div>

        <!-- 支払方法（右側表示用） -->
        <div class="buy-card flex justify-between items-center">
            <p class="buy-card-title">支払方法</p>
            <p id="paymentDisplay" class="buy-card-value text-gray-400">
                選択してください
            </p>
        </div>

        <form action="{{ route('deal.store', $product->id) }}" method="POST">
            @csrf
            <input type="hidden" name="payment" id="paymentInput" value="">
            <input type="hidden" name="postcode" value="{{ $user->postcode }}">
            <input type="hidden" name="address" value="{{ $user->address }}">
            <input type="hidden" name="building" value="{{ $user->building }}">

            @error('payment')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit" class="buy-button w-full">購入する</button>
        </form>




    </div>

</div>
<script>
    const paymentSelectLeft = document.getElementById('paymentSelect');
    const paymentDisplay = document.getElementById('paymentDisplay');
    const paymentInput = document.getElementById('paymentInput');

    function updatePayment(value) {
        paymentDisplay.textContent = this.value;
        paymentDisplay.classList.remove('text-gray-400');
        paymentInput.value = this.value;
    }

    paymentSelectLeft.addEventListener('change', function() {
        paymentDisplay.textContent = this.value;
        paymentDisplay.classList.remove('text-gray-400');
        paymentInput.value = this.value;
    });
</script>
@endsection