<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class T04ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_全商品を取得して一覧画面が表示される()
    {
        // 出品者を作成
        $user = \App\Models\User::factory()->create();

        // 商品を作成（Factory 不使用）
        Product::create([
            'name' => 'キウイ',
            'price' => 300,
            'description' => 'テスト用の商品です',
            'user_id' => $user->id,
            'image_path' => 'test.jpg',
            'condition' => '良好', // ← 必須
        ]);

        // 一覧画面へアクセス
        $response = $this->get('/products');

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        // 商品名が表示されていることを確認
        $response->assertSee('キウイ');
    }
}
