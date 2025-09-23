<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Like;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommended');
        $keyword = $request->input('keyword'); // ← ここで必ず取得

        if ($tab === 'mylist') {
            $recommendedProducts = Item::latest()->paginate(12);

            if (auth()->check()) {
                $likedItemIds = Like::where('user_id', auth()->id())->pluck('item_id')->toArray();
                $myList = Item::whereIn('id', $likedItemIds)->get();

            } else {
                $mylist = collect();
            }
        } else {
            $query = Item::query();

            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%")
                        ->orWhere('brand', 'LIKE', "%{$keyword}%")
                        ->orWhere('description', 'LIKE', "%{$keyword}%")
                        ->orWhere('category', 'LIKE', "%{$keyword}%");
                });
            }

            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }

            $recommendedProducts = $query->latest()->paginate(12);
            $myList = collect();
        }

        return view('index', compact('recommendedProducts', 'myList', 'keyword'));
    }


    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('items.show', compact('item'));
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
            'img_url' => 'required|image|max:5120',
            'categories' => 'required|array',
            'condition' => 'required|string',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
        ]);

        $path = $request->file('img_url')->store('items', 'public');
        $validated['img_url'] = $path;

        Item::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? '',
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'img_url' => $path,
            'condition' => $validated['condition'],
            'category' => implode(',', $validated['categories']),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', '商品を出品しました');
    }

    public function app()
    {
        return view('sell');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::when($keyword, function ($query, $keyword) {
        return $query->where('name', 'like', "%{$keyword}%")
                     ->orWhere('brand', 'like', "%{$keyword}%");
        })->paginate(10);

    return view('items.index', compact('items', 'keyword'));
    }
}