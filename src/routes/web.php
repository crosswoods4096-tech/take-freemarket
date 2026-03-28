<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===============================
// 商品（トップ・詳細・出品）
// ===============================

// 商品一覧（トップページ）
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// 商品一覧（全件）
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// おすすめ
Route::get('/products/recommend', [ProductController::class, 'recommend'])->name('products.recommend');

// マイリスト
Route::get('/products/mylist', [ProductController::class, 'mylist'])->name('products.mylist');

// マイリスト（自分の出品一覧）
Route::get('/mylist', [ProductController::class, 'indexMyList'])->name('products.mylist');

// 出品フォーム
Route::get('/sell', [ProductController::class, 'create'])->name('products.create');

// 出品登録処理
Route::post('/sell', [ProductController::class, 'store'])->name('products.store');


// ===============================
// 購入フロー
// ===============================

Route::get('/deal/{id}', [DealController::class, 'index'])
    ->name('deal.index');

// 購入確認画面
Route::get('/deal/{id}', [DealController::class, 'showDealForm'])
    ->middleware('auth')
    ->name('deal.show');

// 住所変更画面
Route::get('/deal/address/{id}', [DealController::class, 'editAddress'])
    ->middleware('auth')
    ->name('deal.address.edit');

// 住所更新処理
Route::post('/deal/address/{id}', [DealController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('deal.address.update');

// 購入確定処理
Route::post('/deal/complete/{id}', [DealController::class, 'complete'])
    ->middleware('auth')
    ->name('deal.complete');


// ===============================
// マイページ
// ===============================

// マイページトップ（プロフィール・購入履歴・出品履歴）
Route::get('/mypage', [MypageController::class, 'index'])
    ->middleware('auth')
    ->name('mypage.index');

Route::get('/mypage/edit', [MypageController::class, 'editProfile'])->name('mypage.edit');

// プロフィール編集
Route::get('/mypage/profile', [MypageController::class, 'editProfile'])
    ->middleware('auth')
    ->name('mypage.profile.edit');

// プロフィール更新
Route::post('/mypage/profile', [MypageController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('mypage.profile.update');

// ===============================
// コメント機能
// ===============================

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// ===============================
// 会員登録機能
// ===============================

// 会員登録画面
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'store'])->name('register.post');


// ===============================
// ログイン機能
// ===============================

// ログイン画面
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ログイン処理
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
