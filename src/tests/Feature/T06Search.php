<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        // 検索にヒットする商品
        Product::factory()->create(['name' => 'ドラゴンフルーツ']);
        // 検索にヒットしない商品
        Product::factory()->create(['name' => 'バナナ']);

        // 検索実行（GET /products?keyword=ドラ）
        $response = $this->get('/products?keyword=ドラ');

        // 部分一致する商品は表示される
        $response->assertSee('ドラゴンフルーツ');

        // 一致しない商品は表示されない
        $response->assertDontSee('バナナ');
    }

    /** @test */
    public function 検索状態がマイリストでも保持される()
    {
        $user = User::factory()->create();

        // 商品を作成
        $product = Product::factory()->create(['name' => 'キウイ']);
        $user->likes()->attach($product->id); // マイリストに追加

        // ホーム画面で検索（GET /products?keyword=キ）
        $response = $this->actingAs($user)->get('/products?keyword=キ');

        // 検索結果が表示される
        $response->assertSee('キウイ');

        // マイリスト画面へ遷移（GET /mylist?keyword=キ）
        $response = $this->actingAs($user)->get('/mylist?keyword=キ');

        // マイリストでも検索キーワードが保持されている
        $response->assertSee('キウイ');
    }
}
