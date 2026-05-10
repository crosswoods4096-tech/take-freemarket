<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class T14ChangeUserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー情報変更画面に過去の設定値が初期表示される()
    {
        // ユーザー作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),
            'avatar' => 'avatars/test-avatar.jpg',
            'postcode' => '123-4567',
            'address' => '千葉県松戸市テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        // プロフィール編集画面へアクセス
        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSee('avatars/test-avatar.jpg');
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('千葉県松戸市テスト町1-2-3');
        $response->assertSee('テストマンション101');
    }
}
