<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 小計画面で支払方法の変更が反映される
     */
    public function test_小計画面で支払方法の変更が反映される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 3000,
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
