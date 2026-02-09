<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'icon',
        'post_code',
        'address',
        'building',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedItems()
    {
        return $this->belongsToMany(Item::class, 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sellingTransactions()
    {
        return $this->hasMany(Trnsaction::class, 'seller_id');
    }

    public function buyingTransactions() 
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function receivedRatings()
    {
        return Transaction::where(function ($q) {
            $q->where('seller_id', $this->id)
              ->whereNotNull('buyer_rating');
        })
        ->orWhere(function ($q) {
            $q->where('buyer_id', $this->id)
              ->whereNotNull('seller_rating');
        });
    }

    public function getAverageRatingAttribute()
    {
        $ratings = [];

        // 出品者として受け取った評価
        $sellerRatings = Transaction::where('seller_id', $this->id)
            ->whereNotNull('buyer_rating')
            ->pluck('buyer_rating')
            ->toArray();

        // 購入者として受け取った評価
        $buyerRatings = Transaction::where('buyer_id', $this->id)
            ->whereNotNull('seller_rating')
            ->pluck('seller_rating')
            ->toArray();

        $ratings = array_merge($sellerRatings, $buyerRatings);

        if (count($ratings) === 0) {
            return null; // 評価なし
        }

        return round(array_sum($ratings) / count($ratings));
    }
}
