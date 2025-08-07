@extends('layouts.simple')

@section('content')
<div class="register-container">
    <h2 class="title">会員登録</h2>
    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="register-button">登録する</button>

        <p class="login-link">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </p>
    </form>
</div>
@endsection
