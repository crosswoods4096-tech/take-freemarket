<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 商品出品画面にて必要な情報が保存されること
     * （カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）
     */
    public function test_商品出品画面で入力した情報が保存される()
    {
        $user = User::factory()->create();

        // カテゴリを複数作成
        $cat1 = Category::factory()->create(['name' => 'フルーツ']);
        $cat2 = Category::factory()->create(['name' => '南国']);

        // 出品データ
        $postData = [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文です。',
            'condition' => '新品',
            'price' => 3000,
            'categories' => [$cat1->id, $cat2->id],
        ];

        // ログイン状態で出品実行
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

        // 正常にリダイレクトされる（一覧画面など）
        $response->assertRedirect('/products');
    }
}
