<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;


class T10BuyTest extends TestCase
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

    private function createProduct($user, $name = 'テスト商品')
    {
        return Product::create([
            'user_id' => $user->id,
            'name' => $name,
            'description' => '説明文',
            'price' => 1000,
            'condition' => '新品',
            'image_path' => 'test.jpg',
        ]);
    }

    /**
     * ① 購入するボタンを押すと購入が完了する
     */
    public function test_購入ボタンを押すと購入が完了する()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user);

        $response = $this->actingAs($user)->post('/deal/' . $product->id);

        // 購入テーブルに登録されている
        $this->assertDatabaseHas('deals', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response->assertRedirect('/products');
    }

    /**
     * ② 購入した商品は商品一覧画面で SOLD と表示される
     */
    public function test_購入した商品は一覧画面でSOLDと表示される()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user, 'テスト商品');

        // 購入処理
        $this->actingAs($user)->post('/deal/' . $product->id);

        // 一覧画面へアクセス
        $response = $this->get('/products');

        // SOLD 表示があること
        $response->assertSee('SOLD');
        $response->assertSee('テスト商品');
    }

    /**
     * ③ プロフィールの購入商品一覧に表示される
     */
    public function test_購入した商品がプロフィールの購入一覧に表示される()
    {
        $user = $this->createUser();
        $product = $this->createProduct($user, '購入商品テスト');

        // 購入処理
        $this->actingAs($user)->post('/deal/' . $product->id);

        // プロフィールの購入商品一覧へアクセス
        $response = $this->actingAs($user)->get('/profile/purchased');

        $response->assertSee('購入商品テスト');
    }
}
