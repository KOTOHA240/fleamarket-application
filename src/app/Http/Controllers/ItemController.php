<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // 認証機能が整ったら使う

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // タブ判定（おすすめ or マイリスト）
        $tab = $request->query('tab', 'recommended');

        if ($tab === 'mylist') {
            // 認証機能ができてから有効化予定
            // if (Auth::check()) {
            //     $user = Auth::user();
            //     $myList = $user->favorites()->latest()->get();
            // } else {
            //     $myList = collect(); // 空のコレクション
            // }
            $myList = collect(); // 仮データ
            $recommendedProducts = Item::latest()->get();
        } else {
            $recommendedProducts = Item::latest()->get(); // おすすめ商品一覧
            $myList = collect(); // マイリストは空
        }

        return view('index', compact('recommendedProducts', 'myList'));
    }
}

