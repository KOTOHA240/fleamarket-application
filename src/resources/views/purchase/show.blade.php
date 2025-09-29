@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
<div class="purchase-container">
    <div class="purchase-main">
        <form method="POST" action="{{ route('purchase.store', $item->id) }}">
            @csrf
            <div class="purchase-container">
                <div class="purchase-main">
                    <div class="purchase-product">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="商品画像" class="purchase-image">
                        <div class="purchase-info">
                            <h2>{{ $item->name }}</h2>
                            <p>¥{{ number_format($item->price) }}</p>
                        </div>
                    </div>

                    <div class="purchase-section">
                        <label for="payment_method">支払い方法</label>
                        <select id="payment_method" name="payment_method">
                            <option value="">選択してください</option>
                            <option value="コンビニ払い">コンビニ払い</option>
                            <option value="カード払い">カード払い</option>
                        </select>
                        @error('payment_method')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="purchase-section address-section">
                        <div class="address-header">
                            <label>配送先</label>
                            <a href="{{ route('purchase.address.edit', $item->id) }}">変更する</a>
                        </div>
                        <p>〒 {{ $purchaseAddress->post_code ?? $user->post_code ?? 'XXX-YYYY' }}<br>
                            {{ $purchaseAddress->address ?? $user->address ?? '住所未登録' }}
                            {{ $purchaseAddress->building ?? $user->building ?? '' }}
                        </p>
                        @error('address')
                            <div class="error">{{ $message }}</div>
                        @enderror
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

                    <button type="submit" class="purchase-btn">購入する</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('payment_method').addEventListener('change', function() {
    document.getElementById('selected-method').textContent = this.value || '-';
});
</script>
@endsection

