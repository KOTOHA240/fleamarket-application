@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h1 class="sell-title">商品を出品する</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group">
            <label for="img_url">商品画像 <span class="required">*</span></label>
            <label  class="img_url-upload-box" for="img_url">
                <span>画像を選択する</span>
            </label>
            <input type="file" name="img_url" id="img_url" accept="image/*">
            @error('img_url')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- カテゴリ --}}
        <div class="form-group">
            <label class="section-title">商品の詳細</label>
            <hr class="section-line">

            <label for="categories">カテゴリー <span class="required">*</span></label>
            <div class="category-tags">
                <input type="checkbox" id="fashion" name="categories[]" value="ファッション">
                <label for="fashion">ファッション</label>

                <input type="checkbox" id="electronics" name="categories[]" value="家電">
                <label for="electronics">家電</label>

                <input type="checkbox" id="interior" name="categories[]" value="インテリア">
                <label for="interior">インテリア</label>

                <input type="checkbox" id="ladies" name="categories[]" value="レディース">
                <label for="ladies">レディース</label>

                <input type="checkbox" id="mens" name="categories[]" value="メンズ">
                <label for="mens">メンズ</label>

                <input type="checkbox" id="cosmetics" name="categories[]" value="コスメ">
                <label for="cosmetics">コスメ</label>

                <input type="checkbox" id="books" name="categories[]" value="本">
                <label for="books">本</label>

                <input type="checkbox" id="games" name="categories[]" value="ゲーム">
                <label for="games">ゲーム</label>

                <input type="checkbox" id="sports" name="categories[]" value="スポーツ">
                <label for="sports">スポーツ</label>

                <input type="checkbox" id="kitchen" name="categories[]" value="キッチン">
                <label for="kitchen">キッチン</label>

                <input type="checkbox" id="handmade" name="categories[]" value="ハンドメイド">
                <label for="handmade">ハンドメイド</label>

                <input type="checkbox" id="accessory" name="categories[]" value="アクセサリー">
                <label for="accessory">アクセサリー</label>

                <input type="checkbox" id="toys" name="categories[]" value="おもちゃ">
                <label for="toys">おもちゃ</label>

                <input type="checkbox" id="baby_kids" name="categories[]" value="ベビー・キッズ">
                <label for="baby_kids">ベビー・キッズ</label>
            </div>
            @error('categories')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition">商品の状態 <span class="required">*</span></label>
            <select name="condition" id="condition">
                <option value="" selected disabled>選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <div class="form-group">
            <label class="section-title">商品名と説明</label>
            <hr class="section-line">

            {{-- 商品名 --}}
            <label for="name">商品名 <span class="required">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand">

            <label for="description">商品説明 <span class="required">*</span></label>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
            <label for="price">販売価格<span class="required">*</span></label>
            <div class="price-input">
                <span class="yen-mark">￥</span>
                <input type="number" name="price" id="price" value="{{ old('price') }}" min="1">
            </div>
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 出品ボタン --}}
        <div class="form-actions">
            <button type="submit" class="btn-sell-button">出品する</button>
        </div>
    </form>
</div>
@endsection
