<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $user = auth()->user();
        if (!$item->isLikedBy($user)) {
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
        return back();
    }

    public function destroy(Item $item)
    {
        Like::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->delete();

        return back();
    }
}
