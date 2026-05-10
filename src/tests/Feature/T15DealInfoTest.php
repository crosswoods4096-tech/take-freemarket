<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class T15DealInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品出品画面で入力した情報が保存される()
    {
        // ユーザー作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user3@example.com',
            'password' => bcrypt('password123'),
        ]);

        // カテゴリ作成
        $cat1 = Category::create(['name' => 'フルーツ']);
        $cat2 = Category::create(['name' => '南国']);

        // 出品データ
        $postData = [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文です。',
            'condition' => '新品',
            'price' => 3000,
            'categories' => [$cat1->id, $cat2->id],
        ];

        // 出品実行
        $response = $this->actingAs($user)->post('/products', $postData);

        // 商品が保存されていること
        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文です。',
            'condition' => '新品',
            'price' => 3000,
            'user_id' => $user->id,
        ]);

        // 保存された商品を取得
        $product = Product::first();

        // カテゴリが紐づいていること
        $this->assertTrue($product->categories->contains($cat1->id));
        $this->assertTrue($product->categories->contains($cat2->id));

        // 正常にリダイレクトされる
        $response->assertRedirect('/products');
    }
}
