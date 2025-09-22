@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tabs">
    <button class="tab-button {{ request('tab', 'recommended') === 'recommended' ? 'active' : '' }}" data-tab="recommended">おすすめ</button>
    <button class="tab-button {{ request('tab') === 'mylist' ? 'active' : '' }}" data-tab="mylist">マイリスト</button>
</div>

<div id="recommended" class="tab-content {{ request('tab', 'recommended') === 'recommended' ? 'active' : '' }}">
    {{-- 検索ワードがあれば表示 --}}
    @if(!empty($keyword))
        <p class="search-result-message">「{{ $keyword }}」の検索結果</p>
    @endif

    <div class="product-list">
        @foreach($recommendedProducts as $product)
            <div class="product-item">
                <a href="{{ route('items.show', $product->id) }}">
                    <div class="product-image-wrapper">
                        @if($product->is_sold)
                            <div class="sold-label">Sold</div>
                        @endif
                        <img src="{{ asset('storage/' . $product->img_url) }}" alt="{{ $product->name }}">
                    </div>
                    <p>{{ $product->name }}</p>
                </a>
            </div>
        @endforeach
    </div>
    {{-- ページネーション --}}
    {{ $recommendedProducts->links() }}
</div>

<div id="mylist" class="tab-content {{ request('tab') === 'mylist' ? 'active' : '' }}">
    @auth
        <div class="product-list">
            @forelse($myList as $product)
                <div class="product-item">
                    <a href="{{ route('items.show', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->img_url) }}" alt="{{ $product->name }}">
                        <p>{{ $product->name }}</p>
                    </a>
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
        const tab = button.dataset.tab;
        history.replaceState(null, '', `?tab=${tab}`);

        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        button.classList.add('active');
        document.getElementById(tab).classList.add('active');
    });
});
</script>
@endsection
