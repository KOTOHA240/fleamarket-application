<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\ItemController;

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
