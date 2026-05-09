<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * ① いいねボタンを押すことでいいねした商品に登録できる
     */
    public function test_いいねボタンを押すと商品がいいね登録される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ログイン状態でいいね実行
        $response = $this->actingAs($user)->post('/products/' . $product->id . '/like');

        // likes テーブルに登録されていること
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 商品詳細へ戻る
        $response->assertRedirect('/products/' . $product->id);
    }

    /**
     * ② いいねボタンを押すことで、アイコンの色が変化する
     * （例：🤍 → ❤️ に変わる）
     */
    public function test_いいねするとアイコンが赤色ハートに変化する()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // いいね前の画面（白ハート 🤍）
        $responseBefore = $this->actingAs($user)->get('/products/' . $product->id);
        $responseBefore->assertSee('🤍');

        // いいね実行
        $this->actingAs($user)->post('/products/' . $product->id . '/like');

        // いいね後の画面（赤ハート ❤️）
        $responseAfter = $this->actingAs($user)->get('/products/' . $product->id);
        $responseAfter->assertSee('❤️');
    }

    /**
     * ③ いいねボタンをもう一度押すことでいいねを解除できる
     */
    public function test_いいねボタンをもう一度押すといいね解除される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // 事前にいいねしておく
        $user->likes()->attach($product->id);

        // いいね解除実行
        $response = $this->actingAs($user)->delete('/products/' . $product->id . '/like');

        // likes テーブルから削除されていること
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 商品詳細へ戻る
        $response->assertRedirect('/products/' . $product->id);
    }
}
