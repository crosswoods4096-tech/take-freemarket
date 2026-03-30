@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')

<div class="sell-container">

    <h1 class="title">商品の出品</h1>

    {{-- 商品画像 --}}
    <div class="image-upload">
        <label class="image-label">商品画像</label>
        <input type="file" name="image" class="image-input">
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf
        {{-- カテゴリー --}}
        <select name="categories[]" multiple class="form-select">
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

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

        {{-- 商品名 --}}
        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-input">
        </div>

        {{-- ブランド名 --}}
        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-input">
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" class="form-textarea"></textarea>
        </div>

        {{-- 販売価格 --}}
        <div class="form-group">
            <label class="form-label">販売価格</label>
            <input type="number" name="price" class="form-input">
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-btn">出品する</button>

    </form>

</div>

@endsection