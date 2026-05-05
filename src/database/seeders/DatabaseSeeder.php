<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // まずユーザーを1人作成（ProductSeeder が user_id=1 を使うため）
        User::firstOrCreate(
            ['email' => 'test1@example.com'],
            [
                'name' => 'テストユーザー１',
                'password' => bcrypt('password'),
                'postcode' => '125-0042',
                'address' => 'Tokyo'
            ]
        );
        User::firstOrCreate(
            ['email' => 'test2@example.com'],
            [
                'name' => 'テストユーザー２',
                'password' => bcrypt('password'),
                'postcode' => '271-0094',
                'address' => 'Chiba'
            ]
        );
        // カテゴリー
        $this->call(CategorySeeder::class);

        // 商品
        $this->call(ProductSeeder::class);
    }
}
