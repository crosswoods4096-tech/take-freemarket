<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class T09CommentTest extends TestCase
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
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => '説明文',
            'price' => 1000,
            'condition' => '新品',
            'image_path' => 'test.jpg',
        ]);
    }

    /**
     * ① ログイン済みのユーザーはコメントを送信できる
     */
    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => 'とても良い商品ですね！',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'とても良い商品ですね！', // ← content に統一
        ]);

        $response->assertRedirect('/products/' . $product->id);
    }

    /**
     * ② ログイン前のユーザーはコメントを送信できない
     */
    public function test_未ログインユーザーはコメントを送信できない()
    {
        $owner = $this->createUser();
        $product = $this->createProduct($owner);

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => 'ログインしていないコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'content' => 'ログインしていないコメント', // ← content に統一
        ]);
    }

    /**
     * ③ コメント未入力の場合バリデーションエラーになる
     */
    public function test_コメント未入力の場合バリデーションエラーになる()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    /**
     * ④ コメントが255文字以上の場合バリデーションエラーになる
     */
    public function test_コメントが255文字以上の場合バリデーションエラーになる()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
