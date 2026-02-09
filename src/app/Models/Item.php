<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'img_url',
        'condition',
        'category',
        'user_id',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}