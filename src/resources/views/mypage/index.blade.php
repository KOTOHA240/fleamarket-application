@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    {{-- プロフィール --}}
    <div class="profile-section">
        <img src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('images/default-icon.png') }}"
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
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('items.show', $product->id) }}">
                    <div class="image">
                        <img src="{{ asset('storage/' . $product->img_url) }}" alt="{{ $product->name }}">
                    </div>
                    <p>{{ $product->name }}</p>
                </a>
            </div>
        @empty
            <p>{{ $tab === 'sell' ? '出品した商品はありません。' : '購入した商品はありません。' }}</p>
        @endforelse
    </div>
</div>
@endsection

