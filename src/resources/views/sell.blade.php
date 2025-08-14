@extends('layouts.app')

@section('content')
<div class="sell-container">
    <h1 class="sell-title">商品を出品する</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group">
            <label for="image">商品画像 <span class="required">*</span></label>
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name">商品名 <span class="required">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label for="description">商品説明 <span class="required">*</span></label>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- カテゴリ --}}
        <div class="form-group">
            <label for="category">カテゴリ <span class="required">*</span></label>
            <select name="category" id="category">
                <option value="">選択してください</option>
                <option value="fashion" {{ old('category') == 'fashion' ? 'selected' : '' }}>ファッション</option>
                <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>家電</option>
                <option value="hobby" {{ old('category') == 'hobby' ? 'selected' : '' }}>趣味・スポーツ</option>
                <option value="others" {{ old('category') == 'others' ? 'selected' : '' }}>その他</option>
            </select>
            @error('category')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <label for="price">価格（円）<span class="required">*</span></label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" min="1">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 出品ボタン --}}
        <div class="form-actions">
            <button type="submit" class="btn-sell">出品する</button>
        </div>
    </form>
</div>
@endsection
