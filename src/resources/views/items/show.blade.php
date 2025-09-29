@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    {{-- 左：商品画像 --}}
    <div class="left">
        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
    </div>

    {{-- 右：商品情報 --}}
    <div class="right">
        <h2 class="item-name">{{ $item->name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">¥{{ number_format($item->price) }} <span>(税込)</span></p>

        {{-- いいね＆コメント数 --}}
        <div class="stats">
            <div class="stat-block">
                @auth
                    <form action="{{ $item->isLikedBy(auth()->user()) ? route('items.unlike', $item->id) : route('items.like', $item->id) }}" method="POST">
                        @csrf
                        @if($item->isLikedBy(auth()->user()))
                            @method('DELETE')
                            <button type="submit" class="like-button"><i class="fa-solid fa-star"></i></button>
                        @else
                            <button type="submit" class="like-button"><i class="fa-regular fa-star"></i></button>
                        @endif
                    </form>
                @else
                    <i class="fa-regular fa-star like-button"></i>
                @endauth
                <span class="stat-count">{{ $item->likes->count() }}</span>
            </div>

            <div class="stat-block">
                <i class="fa-regular fa-comment"></i>
                <span class="stat-count">{{ $item->comments->count() }}</span>
            </div>
        </div>

        {{-- 購入ボタン --}}
        <a href="{{ route('purchase.show', $item->id) }}" class="btn-purchase">購入手続きへ</a>

        {{-- 商品説明 --}}
        <h3>商品説明</h3>
        <p class="item-description">{{ $item->description }}</p>

        {{-- 商品情報 --}}
        <h3>商品の情報</h3>
        <div class="item-info">
            <p><strong>カテゴリー:</strong>
                @if($item->category)
                    @foreach(explode(',', $item->category) as $cat)
                        <span class="category-tag">{{ $cat }}</span>
                    @endforeach
                @else
                    なし
                @endif
            </p>
            <p><strong>商品の状態:</strong> {{ $item->condition }}</p>
        </div>

        {{-- コメント欄 --}}
        <h3>コメント ({{ $item->comments->count() }})</h3>
        @foreach($item->comments as $comment)
            <div class="comment-item">
                <div class="comment-user">
                    <img src="{{ $comment->user->icon_url ?? '/images/default-icon.png' }}" class="user-icon"  alt="ユーザーアイコン">
                    <span class="user-name">{{ $comment->user->name }}</span>
                </div>
                <div class="comment-content">
                    {{ $comment->body }}
                </div>
            </div>
        @endforeach

        {{-- コメント投稿フォーム --}}
        @auth
            <form action="{{ route('comments.store', $item->id) }}" method="POST" class="comment-form">
                @csrf
                <textarea name="body" placeholder="商品のコメントを入力してください">{{ old('body') }}</textarea>
                @error('body')
                <div class="error">{{ $message }}</div>
                @enderror
                <button type="submit">コメントを送信する</button>
            </form>
        @endauth
    </div>
</div>
@endsection
