<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class T12ChangeAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 送付先住所変更画面で変更した内容が商品購入画面に反映される
     */
    public function test_住所変更が購入画面に反映される()
    {
        // ユーザー作成（factory 不使用）
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test1@example.com',
            'password' => bcrypt('password123'),
            'postcode' => '111-1111',
            'address' => '旧住所',
            'building' => '旧マンション',
        ]);

        // 商品作成（factory 不使用）
        $product = Product::create([
            'name' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'condition' => '良好',
            'description' => 'テスト用の商品です。',
            'user_id' => $user->id,
        ]);

        // ログイン状態で住所変更を実行
        $this->actingAs($user)->post('/address/update', [
            'postcode' => '222-2222',
            'address' => '新住所',
            'building' => '新マンション',
        ]);

        // 購入画面へアクセス
        $response = $this->actingAs($user)->get('/buy/' . $product->id);

        // 新しい住所が反映されていること
        $response->assertSee('222-2222');
        $response->assertSee('新住所');
        $response->assertSee('新マンション');
    }

    /**
     * ② 購入した商品に送付先住所が紐づいて登録される
     */
    public function test_購入した商品に住所が紐づいて保存される()
    {
        // ユーザー作成（factory 不使用）
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test2@example.com',
            'password' => bcrypt('password123'),
            'postcode' => '333-3333',
            'address' => 'テスト住所',
            'building' => 'テストマンション',
        ]);

        // 商品作成（factory 不使用）
        $product = Product::create([
            'name' => 'テスト商品',
            'price' => 2000,
            'image_path' => 'test.jpg',
            'condition' => '良好',
            'description' => 'テスト用の商品です。',
            'user_id' => $user->id,
        ]);

        // 購入処理
        $this->actingAs($user)->post('/purchase/' . $product->id);

        // purchases テーブルに住所が保存されていること
        $this->assertDatabaseHas('deals', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postcode' => '333-3333',
            'address' => 'テスト住所',
            'building' => 'テストマンション',
        ]);
    }
}
