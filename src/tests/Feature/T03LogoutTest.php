<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class T03LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン中にログアウトするとログアウトされログイン画面へリダイレクトされる()
    {
        // ログイン済みユーザーを作成
        $user = User::factory()->create();

        // actingAs でログイン状態にする
        $this->actingAs($user);

        // ログアウト実行（POST /logout）
        $response = $this->post('/logout');

        // ログアウトされていることを確認
        $this->assertGuest();

        // ログイン画面へリダイレクトされることを確認
        $response->assertRedirect('/login');
    }
}
