<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Message;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('page', 'sell');

        $unreadTransactionCount = Transaction::where(function ($q) use ($user) {
                $q->where('buyer_id', $user->id)
                  ->orWhere('seller_id', $user->id);
        })
        ->where('status', 'in_progress')
        ->whereHas('messages', function ($q) use ($user) {
            $q->where('is_read', false)
              ->where('sender_id', '!=', $user->id);
        })
        ->count();

        $notificationCount = $unreadTransactionCount;

        // 出品した商品
        if ($tab === 'sell') {
            $products = $user->items;
            $transactions = [];
        }
        // 購入した商品
        elseif ($tab === 'buy') {
            $products = $user->purchases()->with('item')->get()->pluck('item');
            $transactions = [];
        }
        // 取引中の商品
        elseif ($tab === 'transaction') {
            $products = [];

            $transactions = Transaction::where(function ($q) use ($user) {
                $q->where('buyer_id', $user->id)
                  ->orWhere('seller_id', $user->id);
            })
            ->where('status', 'in_progress')
            ->with('item')
            ->get();
        }

        return view('mypage.index', compact('user', 'tab', 'products', 'transactions', 'notificationCount'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }
}
