<a href="{{ route('products.show', $product->id) }}"
    class="block bg-white rounded shadow hover:shadow-lg transition p-2">

    <img src="{{ asset('storage/' . $product->image) }}"
        class="w-full h-60 object-cover rounded">

    <div class="flex justify-between items-center mt-2 px-1">
        <span class="text-gray-800 font-semibold text-base">
            {{ $product->name }}
        </span>
        <span class="text-gray-900 font-bold text-base">
            ¥{{ number_format($product->price) }}
        </span>
    </div>
</a>