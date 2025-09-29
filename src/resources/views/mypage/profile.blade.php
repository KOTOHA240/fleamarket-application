@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <div class="profile-image">
        <div class="profile-image-row">
            <div class="profile-icon-wrapper">
                @if(auth()->user()->icon)
                    <img id="preview" src="{{ asset('storage/' . auth()->user()->icon) }}" alt="プロフィール画像" class="profile-icon">
                @else
                    <div class="profile-icon-placeholder">No Image</div>
                @endif
            </div>

            <button type="button" class="image-select-button" onclick="document.getElementById('icon').click()">
                画像を選択する
            </button>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="file" id="icon" name="icon" accept="image/*" style="display:none;">
        @error('icon')
            <p class="error">{{ $message }}</p>
        @enderror

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', auth()->user()->post_code) }}">
            @error('post_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', auth()->user()->building) }}">
            @error('building')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="submit-button">更新する</button>
    </form>

</div>

<script>
    document.getElementById('icon').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection