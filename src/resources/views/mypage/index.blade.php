@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    {{-- プロフィール --}}
    <div class="profile-section">
        <div class="profile-left">
            <img src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('images/default-icon.png') }}"
                alt="ユーザーアイコン">
            <div class="name-rating-column">
                <h2>{{ $user->name }}</h2>

                <div class="rating-stars">
                    @php
                        $rounded = round($user->average_rating ?? 0); // 四捨五入した整数
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $rounded ? 'filled' : '' }}">★</span>
                    @endfor
                </div>
            </div>
        </div>
            
        <a href="{{ route('mypage.profile.edit') }}" class="edit-profile-btn">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ切り替え --}}
    <div class="mypage-tabs">
        <a href="{{ route('mypage.index', ['page' => 'sell']) }}" 
           class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.index', ['page' => 'buy']) }}" 
           class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
        <a href="{{ route('mypage.index', ['page' => 'transaction']) }}"
            class="{{ $tab === 'transaction' ? 'active' : '' }}">取引中の商品</a>
    </div>

    {{-- 商品一覧 --}}
    <div class="product-grid">
        @if($tab === 'sell' || $tab === 'buy')
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
        @endif

        @if($tab === 'transaction')
            @forelse($transactions as $transaction)
                <div class="product-card">
                    <a href="{{ route('transactions.chat', $transaction->id) }}">
                        <div class="image">
                            <img src="{{ asset('storage/' . $transaction->item->img_url) }}" alt="{{ $transaction->item->name }}">
                        </div>
                        <p>{{ $transaction->item->name }}</p>
                    </a>
                </div>
            @empty
                <p>取引中の商品はありません。</p>
            @endforelse
        @endif
    </div>
</div>
@endsection