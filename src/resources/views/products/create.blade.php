@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')

<div class="sell-container">

    <h1 class="title">商品の出品</h1>

    <form action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group mb-4">
            <label class="form-label">商品画像</label>

            <div class="image-box">
                <label for="image" class="custom-file-btn">
                    画像を選択
                </label>
                <input type="file" id="image" name="image" class="file-input">

                {{-- プレビュー表示 --}}
                <img id="preview" class="preview-image" style="display:none; margin-top:10px; max-width:200px; border-radius:8px;">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <h2 class="section-title">商品の詳細</h2>

        {{-- カテゴリ --}}
        <div class="form-group mb-4">
            <label class="form-label">カテゴリ</label>

            @php
            $oldCategories = old('categories') ? explode(',', old('categories')) : [];
            @endphp

            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $category)
                <button type="button"
                    class="category-toggle-btn {{ in_array((string)$category->id, $oldCategories, true) ? 'active' : '' }}"
                    data-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            {{-- 選択されたカテゴリIDを格納する hidden --}}
            <input type="hidden" name="categories" id="selectedCategories" value="{{ old('categories') }}">

            {{-- ▼ ここを追加 --}}
            @error('categories')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- 商品の状態 --}}
        <div class="form-group">
            <label>商品の状態</label>
            <select name="condition">
                <option value="" disabled {{ old('condition') === null ? 'selected' : '' }}>
                    選択してください
                </option>
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="4" {{ old('condition') == 4 ? 'selected' : '' }}>状態が悪い</option>
            </select>

            @error('condition')
            <div class="text-danger">{{ $message }}</div>
            @enderror

        </div>

        <h2 class="section-title">商品名と説明</h2>

        {{-- 商品名 --}}
        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- ブランド名 --}}
        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-input" value="{{ old('brand') }}">
            @error('brand')
            <div class=" text-danger">{{ $message }}
            </div>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" class="form-textarea">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- 販売価格 --}}
        <div class="form-group">
            <label class="form-label">販売価格</label>

            <div class="flex items-center border rounded px-2">
                <span class="text-gray-600 mr-1">¥</span>
                <input type="text" name="price" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('price') }}">
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-btn">出品する</button>

    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ▼ カテゴリ選択の JS
            const buttons = document.querySelectorAll('.category-toggle-btn');
            const hiddenInput = document.getElementById('selectedCategories');

            const oldSelected = hiddenInput.value ? hiddenInput.value.split(',') : [];

            buttons.forEach(btn => {
                if (oldSelected.includes(btn.dataset.id)) {
                    btn.classList.add('active');
                }

                btn.addEventListener('click', () => {
                    btn.classList.toggle('active');

                    const selected = [...document.querySelectorAll('.category-toggle-btn.active')]
                        .map(b => b.dataset.id);

                    hiddenInput.value = selected.join(',');
                });
            });

            // ▼ 画像プレビューの JS
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('preview');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });

        });
    </script>

    @endsection