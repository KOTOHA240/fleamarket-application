@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    {{-- 左：商品画像 --}}
    <div class="left">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
    </div>

    {{-- 右：商品情報 --}}
    <div class="right">
        <h2>{{ $item->name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">¥{{ number_format($item->price) }} <span>(税込)</span></p>

        {{-- いいね＆コメント数 --}}
        <div class="stats">
            <span>⭐ {{ $item->likes_count ?? 0 }}</span>
            <span>💬 {{ $item->comments->count() }}</span>
        </div>

        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品情報</h3>
        <p>カテゴリー: {{ $item->category }}</p>
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
                <textarea name="body" placeholder="コメントを入力してください"></textarea>
                <button type="submit">コメントを送信する</button>
            </form>
        @endauth
    </div>
</div>
@endsection

