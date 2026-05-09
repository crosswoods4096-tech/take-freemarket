<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserEditInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 変更項目が初期値として過去設定されていること
     * （プロフィール画像、ユーザー名、郵便番号、住所）
     */
    public function test_ユーザー情報変更画面に過去の設定値が初期表示される()
    {
        // 事前にユーザー情報を登録
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar' => 'avatars/test-avatar.jpg',
            'postcode' => '123-4567',
            'address' => '千葉県松戸市テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        // ログイン状態でプロフィール編集画面へアクセス
        $response = $this->actingAs($user)->get('/mypage/profile');

        // プロフィール画像が表示されている
        $response->assertSee('avatars/test-avatar.jpg');

        // ユーザー名
        $response->assertSee('テストユーザー');

        // 郵便番号
        $response->assertSee('123-4567');

        // 住所
        $response->assertSee('千葉県松戸市テスト町1-2-3');

        // 建物名
        $response->assertSee('テストマンション101');
    }
}
