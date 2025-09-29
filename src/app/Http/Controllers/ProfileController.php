<?php

namespace App\Http\Controllers;

use Illuminate\Http\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage.profile');
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

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


