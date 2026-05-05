<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        // いいねした商品
        $likedProduct = Product::factory()->create(['name' => 'いいね商品']);
        $user->likes()->attach($likedProduct->id);

        // いいねしていない商品
        $notLikedProduct = Product::factory()->create(['name' => '非いいね商品']);

        $response = $this->actingAs($user)->get('/mylist');

        // いいねした商品は表示される
        $response->assertSee('いいね商品');

        // いいねしていない商品は表示されない
        $response->assertDontSee('非いいね商品');
    }

    /** @test */
    public function 購入済み商品にはSOLDと表示される()
    {
        $user = User::factory()->create();

        // SOLD の商品を作成
        $soldProduct = Product::factory()->create([
            'name' => '売れた商品',
            'is_sold' => true,
        ]);

        // いいねしている
        $user->likes()->attach($soldProduct->id);

        $response = $this->actingAs($user)->get('/mylist');

        // SOLD 表示があること
        $response->assertSee('SOLD');
        $response->assertSee('売れた商品');
    }

    /** @test */
    public function 未認証の場合は何も表示されない()
    {
        // 商品を作成しても、未ログインなら表示されない
        Product::factory()->create(['name' => '商品A']);

        $response = $this->get('/mylist');

        // ログイン画面へリダイレクトされる仕様ならこちら
        $response->assertRedirect('/login');

        // もし「空の画面を表示する」仕様なら以下に変更
        // $response->assertStatus(200);
        // $response->assertDontSee('商品A');
    }
}
