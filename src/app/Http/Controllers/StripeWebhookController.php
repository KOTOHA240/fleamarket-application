<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // メタデータから商品IDを取得
            $itemId = $session->metadata->item_id ?? null;
            $userId = $session->metadata->user_id ?? null;

            if ($itemId && $userId) {
                $item = Item::find($itemId);
                if ($item && !$item->is_sold) {
                    Purchase::create([
                        'user_id' => $userId,
                        'item_id' => $itemId,
                    ]);
                    $item->is_sold = true;
                    $item->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
