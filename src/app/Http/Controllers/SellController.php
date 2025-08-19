<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SellController extends Controller
{
    public function create()
    {
        return view('sell'); // create → sell に変更
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:1',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
        ]);

        // 画像アップロード
        $path = $request->file('image')->store('products', 'public');

        // DB保存
        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $path,
        ]);

        return redirect()->route('home')->with('success', '商品を出品しました。');
    }
}
