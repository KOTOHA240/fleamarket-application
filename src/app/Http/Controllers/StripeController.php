<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout(Request $request, Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('purchase.show', $item->id)
                ->with('error', 'この商品はすでに売り切れです。');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // ✅ item_id をパスパラメータとして渡す
            'success_url' => route('purchase.success', ['item_id' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.cancel'),

            'metadata' => [
                'item_id' => $item->id,
                'user_id' => Auth::id(),
            ],

        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // カード払いとコンビニ払いを区別
        // session_id を使って Stripe セッションを確認
        $sessionId = $request->query('session_id');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if (in_array('card', $session->payment_method_types)) {
            // ✅ カード払いは即時決済なのでここで購入処理
            Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ]);

            $item->is_sold = true;
            $item->save();

            return redirect()->route('home')->with('success', 'カード決済が完了しました！');
        } else {
            // ✅ コンビニ払いは未決済なので購入処理しない
            return redirect()->route('home')->with(
                'success',
                'コンビニ支払いの受付が完了しました。お支払い完了後に購入が確定します。'
            );
        }
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'カード決済がキャンセルされました。');
    }

    public function checkoutKonbini(Request $request, Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('purchase.show', $item->id)
                ->with('error', 'この商品はすでに売り切れです。');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['konbini'], // ← ここが違うだけ！
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.cancel'),

            'metadata' => [
                'item_id' => $item->id,
                'user_id' => Auth::id(),
            ],
        ]);

        return redirect($session->url);
    }
}
