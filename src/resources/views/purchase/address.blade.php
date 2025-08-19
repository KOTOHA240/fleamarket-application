@extends('layouts.app')

@section('content')
<div class="address-edit-container">
    <h2>住所変更</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST" class="address-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
            @error('building')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">更新する</button>
            <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="btn-back">戻る</a>
        </div>
    </form>
</div>
@endsection

