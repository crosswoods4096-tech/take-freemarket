<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class T08LikesTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function createProduct($user)
    {
        return Product::create([
            'user_id' => $user->id, // 外部キー制約を確実に通す
            'name' => 'テスト商品',
            'description' => '説明文',
            'price' => 1000,
            'condition' => '新品',
            'image_path' => 'test.jpg',
        ]);
    }

    /**
     * ① いいねボタンを押すことでいいねした商品に登録できる
     */
    public function test_いいねボタンを押すと商品がいいね登録される()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/like');

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response->assertRedirect('/products/' . $product->id);
    }

    /**
     * ② いいねボタンを押すことで、アイコンの色が変化する
     */
    public function test_いいねするとアイコンが赤色ハートに変化する()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        // いいね前（白ハート）
        $responseBefore = $this->actingAs($user)->get('/products/' . $product->id);
        $responseBefore->assertSee('🤍');

        // いいね実行
        $this->actingAs($user)->post('/products/' . $product->id . '/like');

        // いいね後（赤ハート）
        $responseAfter = $this->actingAs($user)->get('/products/' . $product->id);
        $responseAfter->assertSee('❤️');
    }

    /**
     * ③ いいねボタンをもう一度押すことでいいねを解除できる
     */
    public function test_いいねボタンをもう一度押すといいね解除される()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        // 事前にいいね
        $user->likes()->attach($product->id);

        // 解除実行
        $response = $this->actingAs($user)->delete('/products/' . $product->id . '/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response->assertRedirect('/products/' . $product->id);
    }
}
