<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Deal;

class T13UserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー情報が正しく取得できる()
    {
        // ユーザー作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'avatar' => 'test-avatar.jpg',
        ]);

        // 出品した商品
        $listed1 = Product::create([
            'name' => '出品商品A',
            'price' => 1000,
            'image_path' => 'a.jpg',
            'condition' => '良好',
            'description' => '説明A',
            'user_id' => $user->id,
        ]);

        $listed2 = Product::create([
            'name' => '出品商品B',
            'price' => 2000,
            'image_path' => 'b.jpg',
            'condition' => '良好',
            'description' => '説明B',
            'user_id' => $user->id,
        ]);

        // 購入した商品
        $purchasedProduct = Product::create([
            'name' => '購入商品A',
            'price' => 3000,
            'image_path' => 'c.jpg',
            'condition' => '良好',
            'description' => '説明C',
            'user_id' => $user->id,
        ]);

        Deal::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
        ]);

        // マイページへアクセス
        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('test-avatar.jpg');
        $response->assertSee('テストユーザー');
        $response->assertSee('出品商品A');
        $response->assertSee('出品商品B');
        $response->assertSee('購入商品A');
    }
}
