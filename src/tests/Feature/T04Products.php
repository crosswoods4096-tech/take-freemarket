<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得して一覧画面が表示される()
    {
        // 商品を3件作成
        Product::factory()->count(3)->create([
            'is_sold' => false,
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);

        // 3件の商品がビューに渡されていることを確認
        $response->assertViewHas('products', function ($products) {
            return $products->count() === 3;
        });
    }

    /** @test */
    public function 購入済みの商品にはSOLDと表示される()
    {
        // SOLDの商品を作成
        $soldProduct = Product::factory()->create([
            'name' => '売れた商品',
            'is_sold' => true,
        ]);

        $response = $this->get('/products');

        // SOLD の文字が表示されていることを確認
        $response->assertSee('SOLD');
        $response->assertSee($soldProduct->name);
    }

    /** @test */
    public function 自分が出品した商品は一覧に表示されない()
    {
        $user = User::factory()->create();

        // 自分の商品
        $myProduct = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        // 他人の商品
        $otherProduct = Product::factory()->create([
            'name' => '他人の商品',
        ]);

        // ログイン状態で一覧へアクセス
        $response = $this->actingAs($user)->get('/products');

        // 自分の商品は表示されない
        $response->assertDontSee('自分の商品');

        // 他人の商品は表示される
        $response->assertSee('他人の商品');
    }
}
