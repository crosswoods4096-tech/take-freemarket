<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;

class T07DetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品詳細画面で必要な情報が表示される()
    {
        // 出品者作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 商品作成（Factory を使わない）
        $product = Product::create([
            'name' => 'キウイ',
            'price' => 300,
            'description' => 'テスト用の商品です',
            'image_path' => 'sample.jpg',
            'condition' => 1,
            'user_id' => $user->id,
        ]);

        // 詳細画面にアクセス
        $response = $this->get('/products/' . $product->id);

        // 必要な情報が表示されるか確認
        $response->assertStatus(200);
        $response->assertSee('キウイ');
        $response->assertSee('300');
        $response->assertSee('テスト用の商品です');
        $response->assertSee('良好');
    }
}
