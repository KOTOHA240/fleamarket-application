<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchase.show', compact('item', 'user'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required|string|max:8',
            'address'     => 'required|string|max:255',
            'building'    => 'nullable|string|max:255',
        ], [
            'postal_code.required' => '郵便番号を入力してください',
            'address.required'     => '住所を入力してください',
        ]);

        $user = Auth::user();
        $user->postal_code = $request->postal_code;
        $user->address     = $request->address;
        $user->building    = $request->building;
        $user->save();

        return redirect()
            ->route('purchase.address.edit', ['item_id' => $item_id])
            ->with('success', '住所を更新しました');
    }
}

