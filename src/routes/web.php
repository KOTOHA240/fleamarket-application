<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

ROute::get('/', [ItemController::class, 'index']);
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile.edit');
Route::get('/item/{item\id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address');
Route::get('/purchase/address', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
Route::put('/purchase/address', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
