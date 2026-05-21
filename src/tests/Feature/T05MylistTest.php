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



    public function test_購入済み商品には_soldと表示される()
    {
        // ユーザー作成
        $user = \App\Models\User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 商品作成（sold_flag は使わない）
        $product = \App\Models\Product::create([
            'name' => 'メロン',
            'price' => 1000,
            'description' => '購入済み商品',
            'user_id' => $user->id,
            'image_path' => 'melon.jpg',
            'condition' => '良好',
        ]);

        // Deal を作成（これが SOLD の根拠）
        \App\Models\Deal::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postcode' => '111-1111',
            'address' => '住所',
            'building' => '建物',
        ]);

        // /mylist にアクセス
        $response = $this->actingAs($user)->get('/mylist');

        // SOLD が表示されることを確認
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
