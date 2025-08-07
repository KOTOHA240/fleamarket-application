@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <div class="profile-image">
        <img src="{{ asset('images/default-user.png') }}" alt="プロフィール画像">
        <button class="image-select-button">画像を選択する</button>
    </div>

    <form action="/profile/update" method="POST">
        @csrf

        <div class="form-group">
            <label for="username">ユーザー名</label>
            <input type="text" id="username" name="username">
        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" id="postcode" name="postcode">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building">
        </div>

        <button type="submit" class="submit-button">更新する</button>
    </form>
</div>
@endsection