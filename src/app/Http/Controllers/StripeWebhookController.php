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
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook Error'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_method_types[0] === 'konbini') {
                $item_id = $session->metadata->item_id;
                $user_id = $session->metadata->user_id;

                $item = Item::find($item_id);
                if ($item && !$item->is_sold) {
                    Purchase::create([
                        'user_id' => $user_id,
                        'item_id' => $item_id,
                        'payment_method' => 'コンビニ払い',
                    ]);

                    $item->is_sold = true;
                    $item->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
