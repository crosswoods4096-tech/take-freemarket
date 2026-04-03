@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')

<div class="sell-container">

    <h1 class="title">商品の出品</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group mb-4">
            <label class="form-label">商品画像</label>

            <div class="image-box">
                <label for="image" class="custom-file-btn">
                    画像を選択
                </label>
                <input type="file" id="image" name="image" class="hidden">
            </div>
        </div>

        <h2 class="section-title">商品の詳細</h2>

        {{-- カテゴリ --}}
        <div class="form-group mb-4">
            <label class="form-label">カテゴリ</label>

            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $category)
                <button type="button"
                    class="category-toggle-btn"
                    data-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            {{-- 選択されたカテゴリIDを格納する hidden --}}
            <input type="hidden" name="categories" id="selectedCategories">
        </div>

        {{-- 商品の状態 --}}
        <div class="form-group">
            <label class="form-label">商品の状態</label>
            <select name="condition" class="form-select">
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <h2 class="section-title">商品名と説明</h2>

        {{-- 商品名 --}}
        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-input" required>
        </div>

        {{-- ブランド名 --}}
        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-input">
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" class="form-textarea" required></textarea>
        </div>

        {{-- 販売価格 --}}
        <div class="form-group">
            <label class="form-label">販売価格</label>

            <div class="flex items-center border rounded px-2">
                <span class="text-gray-600 mr-1">¥</span>
                <input type="number" name="price" class="form-input border-0 focus:ring-0" required>
            </div>
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-btn">出品する</button>

    </form>
</div> {{-- フォームの最後 --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.category-toggle-btn');
        const hiddenInput = document.getElementById('selectedCategories');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.toggle('active');

                const selected = [...document.querySelectorAll('.category-toggle-btn.active')]
                    .map(b => b.dataset.id);

                hiddenInput.value = selected.join(',');
            });
        });
    });
</script>

</div>

@endsection