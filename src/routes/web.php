<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;

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
Route::get('/mylist', [ProductController::class, 'mylist'])
    ->name('products.mylist')
    ->middleware('auth');


// 出品フォーム
Route::get('/sell', [ProductController::class, 'create'])
    ->middleware('auth')
    ->name('products.create');

// 出品登録処理
Route::post('/sell', [ProductController::class, 'store'])
    ->middleware('auth')
    ->name('products.store');


// ===============================
// Deal 購入フロー（完了画面なし）
// ===============================

// 購入確認画面
Route::get('/deal/{id}', [DealController::class, 'index'])
    ->middleware('auth')
    ->name('deal.index');

// 購入処理
Route::post('/deal', [DealController::class, 'store'])->name('deal.store');
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
// Route::get('/mypage', [MypageController::class, 'index'])
//     ->middleware('auth')
//     ->name('mypage.index');

// マイページ（トップ）
Route::get('/mypage', [App\Http\Controllers\MypageController::class, 'index'])
    ->name('mypage')
    ->middleware('auth');

Route::get('/mypage/edit', [MypageController::class, 'editProfile'])->name('mypage.edit');
// プロフィール更新
Route::put('/mypage/update', [MypageController::class, 'update'])
    ->name('mypage.update')
    ->middleware('auth');


// プロフィール編集
Route::get('/mypage/profile', [MypageController::class, 'editProfile'])
    ->middleware('auth')
    ->name('mypage.profile.edit');





// ===============================
// コメント機能
// ===============================

Route::post('/products/{product}/comment', [CommentController::class, 'store'])
    ->name('comments.store');


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

// ===============================
// いいね機能
// ===============================

Route::post('/products/{product}/like', [LikeController::class, 'toggle'])
    ->name('products.like')
    ->middleware('auth');
