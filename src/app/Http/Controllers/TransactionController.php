<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompletedMail;
use App\Http\Requests\MessageRequest;

class TransactionController extends Controller
{
    public function chat(Transaction $transaction)
    {
        if (auth()->id() !== $transaction->buyer_id &&
            auth()->id() !== $transaction->seller_id) {
                abort(403);
        }

        $partner = auth()->id() === $transaction->buyer_id
            ? $transaction->seller
            : $transaction->buyer;
        
        $ongoingTransactions = Transaction::where(function ($q) {
            $q->where('buyer_id', auth()->id())
              ->orWhere('seller_id', auth()->id());
        })
        ->where('status', 'in_progress')
        ->with('item')
        ->get();

        Message::where('transaction_id', $transaction->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $transaction->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('transactions.chat', compact(
            'transaction',
            'partner',
            'ongoingTransactions',
            'messages'
        ));
    }

    public function sendMessage(Request $request, Transaction $transaction)
    {
        if (auth()->id() !== $transaction->buyer_id &&
            auth()->id() !== $transaction->seller_id) {
                abort(403);
        }

        $transaction->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'image_path' => $request->file('image')
                ? $request->file('image')->store('messages', 'public')
                : null,
        ]);

        return redirect()->route('transactions.chat', $transaction);
    }

    public function updateMessage(Request $request, Transaction $transaction, Message $message)
    {
        // 取引に関係ないメッセージは編集不可
        if ($message->transaction_id !== $transaction->id) {
            abort(403);
        }

        // 自分のメッセージ以外は編集不可
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:400',
        ]);

        $message->message = $request->message;
        $message->save();

        return back();
    }

    public function destroyMessage(Transaction $transaction, Message $message)
    {
        // 取引に関係ないメッセージは削除不可
        if ($message->transaction_id !== $transaction->id) {
            abort(403);
        }

        // 自分のメッセージ以外は削除不可
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();

        return back();
    }

    public function rate(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // 購入者が評価する場合
        if (auth()->id() === $transaction->buyer_id) {
            $transaction->buyer_rating = $request->rating;
        }

        // 出品者が評価する場合
        if (auth()->id() === $transaction->seller_id) {
            $transaction->seller_rating = $request->rating;
        }

        $completedNow = false;

        // 双方評価済みなら取引完了
        if ($transaction->buyer_rating && $transaction->seller_rating) {
            $transaction->status = 'completed';
            $completedNow = true;
        }

        $transaction->save();

        // 双方評価済みなら取引完了
        if ($completedNow) {
            Mail::to($transaction->seller->email)
                ->send(new TransactionCompletedMail($transaction));
        }

        return redirect('/');
    }

    public function finish(Transaction $transaction)
    {
        if (auth()->id() !== $transaction->buyer_id) {
            abort(403);
        }

        $transaction->buyer_finished = true;
        $transaction->save();

        return back();
    }
}
