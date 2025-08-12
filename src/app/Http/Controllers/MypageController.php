<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // タブの選択状態（sell または buy）
        $tab = $request->query('page', 'sell');

        return view('mypage.index', compact('user', 'tab'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }
}
