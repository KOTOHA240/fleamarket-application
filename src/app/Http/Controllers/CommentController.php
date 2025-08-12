<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;

public function store(Request $request, $item_id)
{
    $request->validate([
        'body' => 'required|string|max:500'
    ]);

    Comment::create([
        'item_id' => $item_id,
        'user_id' => auth()->id(),
        'body' => $request->body
    ]);

    return redirect()->route('item.show', $item_id);
}