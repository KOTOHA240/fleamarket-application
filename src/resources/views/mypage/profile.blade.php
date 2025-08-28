@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <div class="profile-image">
        @if(auth()->user()->icon)
            <img src="{{ asset('storage/' . auth()->user()->icon) }}" alt="プロフィール画像" class="profile-icon">
        @else
            <img src="{{ asset('images/default-user.png') }}" alt="プロフィール画像" class="profile-icon">
        @endif

        <label for="icon" class="image-select-button">画像を選択する</label>
        <input type="file" id="icon" name="icon" accept="image/*" style="display:none;">
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="icon">プロフィール画像</label>
            <input type="file" id="icon" name="icon" accept="image/*">
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
        </div>

        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', auth()->user()->post_code) }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', auth()->user()->building) }}">
        </div>

        <button type="submit" class="submit-button">更新する</button>
    </form>

</div>
@endsection