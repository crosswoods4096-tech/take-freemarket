<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 必要な情報が取得できる
     * （プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
     */
    public function test_ユーザー情報が正しく取得できる()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar' => 'test-avatar.jpg',
        ]);

        // 出品した商品
        $listed1 = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        $listed2 = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品B',
        ]);

        // 購入した商品
        $purchasedProduct = Product::factory()->create([
            'name' => '購入商品A',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
        ]);

        // マイページへアクセス
        $response = $this->actingAs($user)->get('/mypage');

        // プロフィール画像
        $response->assertSee('test-avatar.jpg');

        // ユーザー名
        $response->assertSee('テストユーザー');

        // 出品した商品一覧
        $response->assertSee('出品商品A');
        $response->assertSee('出品商品B');

        // 購入した商品一覧
        $response->assertSee('購入商品A');
    }
}
