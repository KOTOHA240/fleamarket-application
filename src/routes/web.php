<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\LikeController;

// 未ログインでも見れる部分
Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/items/{item_id}', [ItemController::class, 'show'])->name('items.show');

// ログイン必須の部分
Route::middleware('auth')->group(function () {
    // 出品
    Route::get('/sell', [ItemController::class, 'app'])->name('sell');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');
    Route::post('/items/{item_id}/comment', [CommentController::class, 'store'])->name('comments.store');

    // 購入
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::put('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');

    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/items/{item}/like', [LikeController::class, 'store'])->name('items.like');
    Route::delete('/items/{item}/like', [LikeController::class, 'destroy'])->name('items.unlike');
});

Route::post('/purchase/{item}/checkout', [StripeController::class, 'checkout'])->name('purchase.checkout');
Route::get('/purchase/success/{item_id}', [StripeController::class, 'success'])->name('purchase.success');
Route::get('/purchase/cancel', [StripeController::class, 'cancel'])->name('purchase.cancel');
Route::post('/purchase/{item}/checkout-konbini', [StripeController::class, 'checkoutKonbini'])
    ->name('purchase.checkout.konbini');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);