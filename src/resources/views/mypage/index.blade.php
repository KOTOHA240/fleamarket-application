@extends('layouts.app') {{-- 上部黒地はapp.blade.phpで読み込み --}}

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- プロフィール --}}
    <div class="flex items-center mb-6">
        {{-- ユーザーアイコン --}}
        <img src="{{ $user->icon_path ? asset('storage/' . $user->icon_path) : asset('images/default-icon.png') }}"
             alt="ユーザーアイコン"
             class="w-24 h-24 rounded-full object-cover border">

        <div class="ml-4">
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <a href="{{ route('mypage.profile.edit') }}"
               class="inline-block mt-2 px-4 py-2 bg-red-500 text-white rounded">
               プロフィールを編集
            </a>
        </div>
    </div>

    {{-- タブ切り替え --}}
    <div class="border-b mb-6">
        <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
           class="inline-block px-4 py-2 {{ $tab === 'sell' ? 'border-b-2 border-red-500 text-red-500 font-bold' : '' }}">
           出品した商品
        </a>
        <a href="{{ route('mypage.index', ['page' => 'buy']) }}"
           class="inline-block px-4 py-2 {{ $tab === 'buy' ? 'border-b-2 border-red-500 text-red-500 font-bold' : '' }}">
           購入した商品
        </a>
    </div>

    {{-- 商品一覧 --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- 仮の商品データ --}}
        @for($i = 0; $i < 8; $i++)
            <div class="border rounded p-2">
                <div class="bg-gray-200 w-full h-32 flex items-center justify-center">
                    商品画像
                </div>
                <p class="mt-2 text-center text-sm">商品名</p>
            </div>
        @endfor
    </div>
</div>
@endsection
