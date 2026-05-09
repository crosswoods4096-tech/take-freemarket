<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Like;
use App\Models\Product;
use App\Models\User;



class T05MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_いいねした商品だけが表示される()
    {
        $user = \App\Models\User::factory()->create();

        $product1 = Product::create([
            'name' => 'キウイ',
            'price' => 300,
            'description' => 'テスト用の商品1',
            'user_id' => $user->id,
            'image_path' => 'test1.jpg',
            'condition' => '良好',
        ]);

        $product2 = Product::create([
            'name' => 'バナナ',
            'price' => 200,
            'description' => 'テスト用の商品2',
            'user_id' => $user->id,
            'image_path' => 'test2.jpg',
            'condition' => '良好',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
        ]);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertStatus(200);
        $response->assertSee('キウイ');
        $response->assertDontSee('バナナ');
    }



    /** @test */
    public function test_購入済み商品には_soldと表示される()
    {
        $user = \App\Models\User::factory()->create();

        $product = Product::create([
            'name' => 'メロン',
            'price' => 1000,
            'description' => '購入済み商品',
            'user_id' => $user->id,
            'image_path' => 'melon.jpg',
            'condition' => '良好',
            'sold_flag' => 1, // ← 購入済み
        ]);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }


    /** @test */
    public function test_未認証の場合は何も表示されない()
    {
        $response = $this->get('/mylist');

        $response->assertRedirect('/login');
    }
}
