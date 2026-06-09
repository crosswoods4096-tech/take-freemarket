<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyListController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// ===============================
// 商品（トップ・詳細・マイリスト・出品）
// ===============================

// 商品一覧（トップページ）
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// 商品一覧（全件）
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/products', [ProductController::class, 'store'])->middleware('auth');
// おすすめ
Route::get('/products/recommend', [ProductController::class, 'recommend'])->name('products.recommend');

// マイリスト
Route::get('/mylist', [MyListController::class, 'mylist'])
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
Route::get('/deal/{product}', [DealController::class, 'index'])
    ->middleware('auth')
    ->name('deal.index');
// 住所変更画面
Route::get('/deal/address/{id}', [DealController::class, 'editAddress'])
    ->middleware('auth')
    ->name('deal.address.edit');

// 住所更新処理
Route::post('/deal/address/{id}', [DealController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('deal.address.update');

// 購入確定処理
Route::post('/deal/{product}', [DealController::class, 'store'])
    ->middleware('auth')
    ->name('deal.store');

//購入者データ獲得
Route::get('/profile/purchased', [DealController::class, 'purchased'])
    ->middleware('auth');
// ===============================
// マイページ関連
// ===============================
// マイページ（トップ）
Route::get('/mypage', [MyPageController::class, 'index'])
    ->middleware('auth')
    ->name('mypage');

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

Route::post('/products/{product}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');




// ===============================
// 会員登録機能
// ===============================

// 会員登録画面
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'store'])->name('register.post');

// 登録直後のプロフィール入力画面
Route::get('/register/profile', [MypageController::class, 'registerProfile'])
    ->name('register.profile')
    ->middleware('auth');

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

// いいね登録・解除（POST）
Route::middleware('auth')->group(
    function () {
        Route::post('/products/{product}/like', [LikeController::class, 'toggle'])
            ->name('like.toggle');
    }
);
// いいね解除（DELETE）
Route::middleware('auth')->group(
    function () {
        Route::delete('/products/{product}/like', [LikeController::class, 'destroy'])
            ->name('like.destroy');
    }
);

// ===============================
// 検索機能
// ===============================
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// ===============================
// メール認証機能
// ===============================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

// 誘導画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 認証リンククリック後の処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
