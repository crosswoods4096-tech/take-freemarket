<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 送付先住所変更画面で変更した内容が商品購入画面に反映される
     */
    public function test_住所変更が購入画面に反映される()
    {
        $user = User::factory()->create([
            'postcode' => '111-1111',
            'address' => '旧住所',
            'building' => '旧マンション',
        ]);

        $product = Product::factory()->create();

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
        $user = User::factory()->create([
            'postcode' => '333-3333',
            'address' => 'テスト住所',
            'building' => 'テストマンション',
        ]);

        $product = Product::factory()->create();

        // 購入処理
        $this->actingAs($user)->post('/purchase/' . $product->id);

        // purchases テーブルに住所が保存されていること
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postcode' => '333-3333',
            'address' => 'テスト住所',
            'building' => 'テストマンション',
        ]);
    }
}
