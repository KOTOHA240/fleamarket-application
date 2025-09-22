@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h2>住所の変更</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST" class="address-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{ old('post_code', $purchaseAddress->post_code ?? $user->post_code) }}">
            @error('post_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $purchaseAddress->address ?? $user->address) }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $purchaseAddress->building ?? $user->building) }}">
            @error('building')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">更新する</button>
        </div>
    </form>
</div>
@endsection