<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('page', 'sell');

        if ($tab === 'sell') {
            $products = $user->items; // 出品した商品（ItemモデルにhasManyある想定）
        } else {
            $products = $user->purchases()->with('item')->get()->pluck('item');
        }

        return view('mypage.index', compact('user', 'tab', 'products'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }
}
