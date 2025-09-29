<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'body' => $request->body,
        ]);

        return redirect()->route('items.show', $item_id)->with('message', 'コメントを投稿しました');
    }
}
