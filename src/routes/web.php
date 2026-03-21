<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===============================
// 商品（トップ・詳細・出品）
// ===============================

// 商品一覧（トップページ）
Route::get('/', [ItemController::class, 'index'])->name('products.index');

// 商品一覧（全件）
Route::get('/products', [ItemController::class, 'index'])->name('products.index');

// おすすめ
Route::get('/products/recommend', [ItemController::class, 'recommend'])->name('products.recommend');

// マイリスト
Route::get('/products/mylist', [ItemController::class, 'mylist'])->name('products.mylist');

// マイリスト（自分の出品一覧）
Route::get('/mylist', [ItemController::class, 'indexMyList'])->name('products.mylist');

// 商品詳細
Route::get('/item/{id}', [ItemController::class, 'show'])->name('products.show');

// 出品フォーム
Route::get('/sell', [ItemController::class, 'create'])->name('products.create');

// 出品登録処理
Route::post('/sell', [ItemController::class, 'store'])->name('products.store');


// ===============================
// 購入フロー
// ===============================

// 購入確認画面
Route::get('/purchase/{id}', [PurchaseController::class, 'showPurchaseForm'])
    ->middleware('auth')
    ->name('purchase.show');

// 住所変更画面
Route::get('/purchase/address/{id}', [PurchaseController::class, 'editAddress'])
    ->middleware('auth')
    ->name('purchase.address.edit');

// 住所更新処理
Route::post('/purchase/address/{id}', [PurchaseController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('purchase.address.update');

// 購入確定処理
Route::post('/purchase/complete/{id}', [PurchaseController::class, 'complete'])
    ->middleware('auth')
    ->name('purchase.complete');


// ===============================
// マイページ
// ===============================

// マイページトップ（プロフィール・購入履歴・出品履歴）
Route::get('/mypage', [MypageController::class, 'index'])
    ->middleware('auth')
    ->name('mypage.index');

// プロフィール編集
Route::get('/mypage/profile', [MypageController::class, 'editProfile'])
    ->middleware('auth')
    ->name('mypage.profile.edit');

// プロフィール更新
Route::post('/mypage/profile', [MypageController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('mypage.profile.update');
