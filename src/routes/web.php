<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
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


// おすすめ
Route::get('/products/recommend', [ProductController::class, 'recommend'])->name('products.recommend');

// 検索機能
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware(['auth', 'verified'])->group(
    function () {
        // マイリスト
        Route::get('/mylist', [MyListController::class, 'mylist'])->name('products.mylist');

        // 出品フォーム
        Route::get('/sell', [ProductController::class, 'create'])->name('products.create');

        // 出品登録処理
        Route::post('/sell', [ProductController::class, 'store'])->name('products.store');


        // ===============================
        // Deal 購入フロー（完了画面なし）
        // ===============================
        // 購入成功したときの処理
        Route::get('/deal/success', [DealController::class, 'success'])->name('deal.success');
        // 購入失敗したときの処理
        Route::get('/deal/cancel', [DealController::class, 'cancel'])->name('deal.cancel');
        // 購入確認画面（index から buy メソッドに変更し、ルート名も deal.buy に変更）
        Route::get('/deal/{product}', [DealController::class, 'buy'])->name('deal.buy');

        // 【追加】支払方法の更新処理（Controllerの updatePayment メソッドに対応）
        Route::post('/deal/{product}/payment', [DealController::class, 'updatePayment'])->name('deal.payment.update');

        // 住所変更画面
        Route::get('/deal/address/{id}', [DealController::class, 'editAddress'])->name('deal.address.edit');

        // 住所更新処理
        Route::post('/deal/address/{id}', [DealController::class, 'updateAddress'])->name('deal.address.update');

        // 購入確定処理
        Route::post('/deal/{product}', [DealController::class, 'store'])->name('deal.store');

        // 購入者データ獲得
        Route::get('/profile/purchased', [DealController::class, 'purchased']);

        // ===============================
        // マイページ関連
        // ===============================
        // マイページ（トップ）
        Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

        Route::put('/mypage/update', [MypageController::class, 'update'])->name('mypage.update');

        // プロフィール編集
        Route::get('/mypage/profile', [MypageController::class, 'editProfile'])->name('mypage.profile.edit');

        // ===============================
        // コメント機能
        // ===============================

        Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');





        // 登録直後のプロフィール入力画面
        Route::get('/register/profile', [MypageController::class, 'registerProfile'])->name('register.profile');


        // ===============================
        // いいね機能
        // ===============================

        // いいね登録
        Route::post('/products/{product}/like', [LikeController::class, 'toggle'])
            ->name('like.toggle');
        //いいね解除
        Route::delete('/products/{product}/like', [LikeController::class, 'destroy'])
            ->name('like.destroy');






        // ===============================
        // メール認証機能
        // ===============================

        Route::get('/dashboard', function () {
            return redirect()->route('register.profile');
        });
    }
);

Route::middleware('auth')->group(function () {
    // 誘導画面（verifiedグループの外に出しました）
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
});
// 認証リンククリック後の処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    // route()関数を使って、名前付きルートを指定する
    return redirect()->route('register.profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//オリジナルのバリデーションを働かせるためのルート設定（登録）
Route::post('/register', [AuthController::class, 'store']);
//オリジナルのバリデーションとログイン処理を働かせるルート設定
Route::post('/login', [AuthController::class, 'login']);
// ログアウト処理を働かせるルート設定
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
