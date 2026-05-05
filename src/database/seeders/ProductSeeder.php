<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'user_id' => 1,
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'sample/Armani+Mens+Clock.jpg',
                'condition' => '良好',
                'categories' => [1, 4], // ← 複数カテゴリー
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'sample/HDD+Hard+Disk.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [2], // 家電
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'sample/iLoveIMG+d.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => [14], // ベビー・キッズなど適当に
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'price' => 4000,
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'sample/Leather+Shoes+Product+Photo.jpg',
                'condition' => '状態が悪い',
                'categories' => [1, 5], // ファッション・メンズ
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'image_path' => 'sample/Living+Room+Laptop.jpg',
                'condition' => '良好',
                'categories' => [2], // 家電
            ],
            [
                'user_id' => 2,
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'sample/Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [2, 8], // 家電・ゲーム
            ],
            [
                'user_id' => 2,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'sample/Purse+fashion+pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => [1, 4], // ファッション・レディース
            ],
            [
                'user_id' => 2,
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_path' => 'sample/Tumbler+souvenir.jpg',
                'condition' => '状態が悪い',
                'categories' => [10], // キッチン
            ],
            [
                'user_id' => 2,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_path' => 'sample/Waitress+with+Coffee+Grinder.jpg',
                'condition' => '良好',
                'categories' => [10], // キッチン
            ],
            [
                'user_id' => 2,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'image_path' => 'sample/外出メイクアップセット.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [6], // コスメ
            ],
        ];

        foreach ($products as $data) {

            // category_id を除いた商品情報を作成
            $product = Product::create([
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'image_path' => $data['image_path'],
                'condition' => $data['condition'],
            ]);

            // 多対多カテゴリーを紐付け
            $product->categories()->attach($data['categories']);
        }
    }
}
