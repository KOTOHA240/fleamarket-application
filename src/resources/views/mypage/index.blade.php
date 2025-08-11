@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile">
    <img src="{{ asset('images/default-user.png') }}" alt="プロフィール画像">
    <button class="profile-edit-button">プロフィールを編集</button>
</div>