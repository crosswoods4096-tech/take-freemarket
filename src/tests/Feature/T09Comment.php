<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① ログイン済みのユーザーはコメントを送信できる
     */
    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => 'とても良い商品ですね！',
        ]);

        // DB にコメントが保存されている
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'とても良い商品ですね！',
        ]);

        // 商品詳細へリダイレクト
        $response->assertRedirect('/products/' . $product->id);
    }

    /**
     * ② ログイン前のユーザーはコメントを送信できない
     */
    public function test_未ログインユーザーはコメントを送信できない()
    {
        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => 'ログインしていないコメント',
        ]);

        // ログイン画面へリダイレクトされる
        $response->assertRedirect('/login');

        // DB に保存されていない
        $this->assertDatabaseMissing('comments', [
            'comment' => 'ログインしていないコメント',
        ]);
    }

    /**
     * ③ コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_コメント未入力の場合バリデーションエラーになる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    /**
     * ④ コメントが255文字以上の場合、バリデーションメッセージが表示される
     */
    public function test_コメントが255文字以上の場合バリデーションエラーになる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('あ', 256); // 256文字

        $response = $this->actingAs($user)->post('/products/' . $product->id . '/comments', [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
