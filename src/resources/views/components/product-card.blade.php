<div class="product-card">
    <a href="{{ route('products.show', $product->id) }}" class="relative block">

        {{-- 商品画像 --}}
        <img src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
            class="product-image">

        {{-- SOLD バッジ --}}
        @if($product->is_sold)
        <div class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-3 py-1 rounded">
            SOLD
        </div>
        @endif
    </a>

    {{-- 商品名 --}}
    <div class="product-name">
        {{ $product->name }}
    </div>
</div>