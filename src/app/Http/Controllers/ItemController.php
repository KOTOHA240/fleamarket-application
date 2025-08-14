<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'favorites') {
            $items = collect(); // 仮データ
        } else {
            $items = Item::latest()->get();
        }

        return view('index', compact('items', 'tab'));
    }

    public function show($item_id)
    {
        $item = Item::with(['comments.user'])->findOrFail($item_id);

        return view('item.show', compact('item'));
    }

    public function sell()
    {
        $categories = ['ファッション', '家電', 'ホビー', 'スポーツ', 'コスメ', '本', 'ゲーム', 'アウトドア', 'インテリア', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];

        return view('items.sell', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'categories' => 'required|array',
            'condition' => 'required|string',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
        ]);

        $path = $request->file('image')->store('items', 'public');

        Item::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? '',
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'image_path' => $path,
            'condition' => $validated['condition'],
            'category' => json_encode($validated['categories']),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }
}
