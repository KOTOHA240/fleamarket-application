<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseAddress;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $purchaseAddress = PurchaseAddress::where('user_id', $user->id)->where('item_id', $item_id)->first();

        return view('purchase.show', compact('item', 'user', 'purchaseAddress'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $purchaseAddress = PurchaseAddress::where('user_id', $user->id)
                                        ->where('item_id', $item_id)
                                        ->first();

        return view('purchase.address', [
            'item' => $item,
            'user' => $user,
            'purchaseAddress' => $purchaseAddress,
        ]);
    }

    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'post_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // 購入時の住所情報を保存（Userの住所ではなく、注文用のアドレステーブルを使うのがおすすめ）
        PurchaseAddress::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item_id],
            [
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );

        return redirect()->route('purchase.show', ['item_id' => $item_id])
                        ->with('success', '住所を更新しました');
    }

    public function store(Item $item)
    {
        if ($item->is_sold) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);

        $item->is_sold = true;
        $item->save();

        return redirect()->route('home')->with('success', '商品を購入しました！');
    }
}

