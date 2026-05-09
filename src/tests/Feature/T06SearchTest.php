<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;

class T06SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品名で部分一致検索ができる()
    {
        // 出品者を作成（Factory を使わない）
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 商品を作成（Factory を使わない）
        Product::create([
            'name' => 'キウイフルーツ',
            'price' => 300,
            'description' => 'テスト用の商品です',
            'image_path' => 'sample.jpg',
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        Product::create([
            'name' => 'バナナ',
            'price' => 200,
            'description' => '別の商品',
            'image_path' => 'sample.jpg',
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        // 検索実行
        $response = $this->get('/search?keyword=キウイ');

        // 部分一致でヒットする
        $response->assertStatus(200);
        $response->assertSee('キウイフルーツ');

        // ヒットしない商品は表示されない
        $response->assertDontSee('バナナ');
    }
}
