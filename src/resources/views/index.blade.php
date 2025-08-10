@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tabs">
    <button class="tab-button active" data-tab="recommended">おすすめ</button>
    <button class="tab-button" data-tab="mylist">マイリスト</button>
</div>

<div id="recommended" class="tab-content active">
    <div class="product-list">
        @foreach($recommendedProducts as $product)
            <div class="product-item">
                @if($product->is_sold)
                    <div class="sold-label">Sold</div>
                @else
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @endif
                <p>{{ $product->name }}</p>
            </div>
        @endforeach
    </div>
</div>

<div id="mylist" class="tab-content">
    @auth
        <div class="product-list">
            @forelse($myList as $product)
                <div class="product-item">
                    @if($product->is_sold)
                        <div class="sold-label">Sold</div>
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @endif
                    <p>{{ $product->name }}</p>
                </div>
            @empty
                <p>マイリストに商品はありません。</p>
            @endforelse
        </div>
    @else
        <p>ログインするとマイリストが表示されます。</p>
    @endauth
</div>

<script>
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        button.classList.add('active');
        document.getElementById(button.dataset.tab).classList.add('active');
    });
});
</script>
@endsection
