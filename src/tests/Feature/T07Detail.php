<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細画面で必要な情報が表示される()
    {
        $user = User::factory()->create();

        // 商品作成
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 3000,
            'description' => 'テスト説明文',
            'condition' => '新品',
            'image' => 'test.jpg',
        ]);

        // カテゴリ
        $category = Category::factory()->create(['name' => 'フルーツ']);
        $product->categories()->attach($category->id);

        // いいね（2件）
        $product->likes()->attach($user->id);
        $product->likes()->attach(User::factory()->create()->id);

        // コメント（2件）
        Comment::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'comment' => 'とても良い商品です',
        ]);

        Comment::factory()->create([
            'product_id' => $product->id,
            'user_id' => User::factory()->create()->id,
            'comment' => 'おすすめです！',
        ]);

        $response = $this->get('/products/' . $product->id);

        // 商品基本情報
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('3000');
        $response->assertSee('テスト説明文');
        $response->assertSee('新品');

        // カテゴリ
        $response->assertSee('フルーツ');

        // いいね数（2件）
        $response->assertSee('2');

        // コメント数（2件）
        $response->assertSee('2');

        // コメント内容
        $response->assertSee('とても良い商品です');
        $response->assertSee('おすすめです！');
    }

    /** @test */
    public function 複数カテゴリが表示される()
    {
        $product = Product::factory()->create(['name' => 'カテゴリテスト商品']);

        // 複数カテゴリ作成
        $cat1 = Category::factory()->create(['name' => 'フルーツ']);
        $cat2 = Category::factory()->create(['name' => '南国']);
        $cat3 = Category::factory()->create(['name' => '高級']);

        $product->categories()->attach([$cat1->id, $cat2->id, $cat3->id]);

        $response = $this->get('/products/' . $product->id);

        // 3つのカテゴリがすべて表示される
        $response->assertSee('フルーツ');
        $response->assertSee('南国');
        $response->assertSee('高級');
    }
}
