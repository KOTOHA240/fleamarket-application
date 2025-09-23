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
        <h2>{{ $item->name }}</h2>
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

                <span class="like-count">{{ $item->likes->count() }}</span>
            </div>

            <div class="stat-block">
                <i class="fa-regular fa-comment"></i>
                <span class="stat-count">{{ $item->comments->count() }}</span>
            </div>
        </div>

        <a href="{{ route('purchase.show', $item->id) }}" class="btn-purchase">購入手続きへ</a>

        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品情報</h3>
        @php
            $categories = json_decode($item->category, true);
        @endphp
        <p>カテゴリー: {{ $categories ? implode(',', $categories) : 'なし' }}</p>
        <p>商品の状態: {{ $item->condition }}</p>

        {{-- コメント欄 --}}
        <h3>コメント ({{ $item->comments->count() }})</h3>
        @foreach($item->comments as $comment)
            <div class="comment-box">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->body }}</p>
            </div>
        @endforeach

        {{-- コメント投稿フォーム --}}
        @auth
            <form action="{{ route('comments.store', $item->id) }}" method="POST" class="comment-form">
                @csrf
                <textarea name="body"></textarea>
                <button type="submit">コメントを送信する</button>
            </form>
        @endauth
    </div>
</div>
@endsection