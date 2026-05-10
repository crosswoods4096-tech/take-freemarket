<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class T11PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 小計画面で支払方法の変更が反映される
     */
    public function test_小計画面で支払方法の変更が反映される()
    {
        // ユーザー作成（factory 不使用）
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品作成（factory 不使用）
        $product = Product::create([
            'name' => 'テスト商品',
            'price' => 3000,
            'image_path' => 'test.jpg',
            'condition' => '良好',
            'description' => 'テスト用の商品です。',
            'user_id' => $user->id,
        ]);

        // ログイン状態で小計画面へアクセス
        $response = $this->actingAs($user)->get('/buy/' . $product->id);

        // 初期状態では「選択してください」が表示されている想定
        $response->assertSee('選択してください');

        // 支払方法を「コンビニ払い」に変更して送信
        $response = $this->actingAs($user)->post('/buy/' . $product->id, [
            'payment' => 'コンビニ払い',
        ]);

        // バリデーションエラーがないこと
        $response->assertSessionHasNoErrors();

        // 小計画面に戻ったときに支払方法が反映されている
        $response = $this->actingAs($user)->get('/buy/' . $product->id);

        $response->assertSee('コンビニ払い');
    }
}
