<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;

Route::get('/', [ItemController::class, 'index'])->name('home');

Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile.edit');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address');
Route::get('/purchase/address', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
Route::put('/purchase/address', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

