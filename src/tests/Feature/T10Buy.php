<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 購入するボタンを押すと購入が完了する
     */
    public function test_購入ボタンを押すと購入が完了する()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'is_sold' => false,
        ]);

        // ログイン状態で購入実行
        $response = $this->actingAs($user)->post('/purchase/' . $product->id);

        // 購入テーブルに登録されている
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 商品が SOLD 状態になっている
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);

        // 購入完了後の遷移先（一覧画面）
        $response->assertRedirect('/products');
    }

    /**
     * ② 購入した商品は商品一覧画面で SOLD と表示される
     */
    public function test_購入した商品は一覧画面でSOLDと表示される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'is_sold' => false,
        ]);

        // 購入処理
        $this->actingAs($user)->post('/purchase/' . $product->id);

        // 一覧画面へアクセス
        $response = $this->get('/products');

        // SOLD 表示があること
        $response->assertSee('SOLD');
        $response->assertSee('テスト商品');
    }

    /**
     * ③ プロフィールの購入商品一覧に表示される
     */
    public function test_購入した商品がプロフィールの購入一覧に表示される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => '購入商品テスト',
            'is_sold' => false,
        ]);

        // 購入処理
        $this->actingAs($user)->post('/purchase/' . $product->id);

        // プロフィールの購入商品一覧へアクセス
        $response = $this->actingAs($user)->get('/profile/purchased');

        // 購入した商品が表示される
        $response->assertSee('購入商品テスト');
    }
}
