<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // プロフィール画像を保存
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $data['icon'] = $path;
        }

        // ユーザー情報を更新
        $user->update($data);

        // 更新後はトップページへ遷移（メッセージなし）
        return redirect('/');
    }
}


