@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
<div class="purchase-container">
    <div class="purchase-main">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" class="purchase-image">

        <div class="purchase-info">
            <h2>{{ $item->name }}</h2>
            <p>¥{{ number_format($item->price) }}</p>
        </div>

        <div class="purchase-section">
            <label for="payment_method">支払い方法</label>
            <select id="payment_method" name="payment_method">
                <option value="">選択してください</option>
                <option value="コンビニ払い">コンビニ払い</option>
                <option value="カード払い">カード払い</option>
            </select>
        </div>

        <div class="purchase-section">
            <label>配送先</label>
            <p>〒 {{ $user->postal_code ?? 'XXX-YYYY' }}<br>
                {{ $user->address ?? '住所未登録' }}
            </p>
            <a href="{{ route('purchase.address', $item->id) }}">変更する</a>
        </div>
    </div>

    <div class="purchase-summary">
        <table>
            <tr>
                <td>商品代金</td>
                <td>¥{{ number_format($item->price) }}</td>
            </tr>
            <tr>
                <td>支払い方法</td>
                <td id="selected-method">-</td>
            </tr>
        </table>
        <button class="purchase-btn">購入する</button>
    </div>
</div>

<script>
document.getElementById('payment_method').addEventListener('change', function() {
    document.getElementById('selected-method').textContent = this.value || '-';
});
</script>
@endsection

