<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T01RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 名前が空の場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }
    /** @test */
    public function メールアドレスが空の場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    /** @test */
    public function パスワードが空の場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }
    /** @test */
    public function パスワードが7文字以下の場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '1234567', // 7文字
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }
    /** @test */
    public function 確認用パスワードが一致しない場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123', // ← 一致しない
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }
    /** @test */
    public function 正しい入力ならユーザーが登録されプロフィール入力画面へリダイレクトされる()
    {
        // 入力データ
        $formData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // POSTリクエスト送信
        $response = $this->post('/register', $formData);

        // DBにユーザーが登録されていることを確認
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        // プロフィール入力画面へリダイレクトされることを確認
        $response->assertRedirect(route('verification.notice'));
        // 例：登録後にプロフィール入力画面へ飛ばす場合
    }
}
