@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    {{-- プロフィール --}}
    <div class="profile-section">
        <img src="{{ $user->icon_path ? asset('storage/' . $user->icon_path) : asset('images/default-icon.png') }}"
             alt="ユーザーアイコン">

        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <a href="{{ route('mypage.profile.edit') }}">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブ切り替え --}}
    <div class="mypage-tabs">
        <a href="{{ route('mypage.index', ['page' => 'sell']) }}" 
           class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.index', ['page' => 'buy']) }}" 
           class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    {{-- 商品一覧 --}}
    <div class="product-grid">
        @for($i = 0; $i < 8; $i++)
            <div class="product-card">
                <div class="image">商品画像</div>
                <p>商品名</p>
            </div>
        @endfor
    </div>
</div>
@endsection

