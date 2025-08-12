<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth; // ログイン機能が整ったら使う

public function index(Request $request)
{
    $tab = $request->query('tab', 'recommend');

    if ($tab === 'favorites') {
        // 認証機能ができてから有効化予定
        // if (Auth::check()) {
        //     $user = Auth::user();
        //     $items = $user->favorites()->latest()->get();
        // } else {
        //     $items = collect(); // 空のコレクション
        // }
        $items = collect(); // 今は仮で空データ
    } else {
        // おすすめ（全件表示）
        $items = Item::latest()->get(); // モデルが未完成ならあとで定義
    }

    return view('index', compact('items', 'tab'));
}

class ItemController extends Controller
{
    public function show($item_id)
    {
        $item = Item::with(['comments.user'])->findOrFail($item_id);

        return view('item.show', compact('item'));
    }
}
