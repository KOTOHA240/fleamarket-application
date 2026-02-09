<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'items/sample1.jpg',
                'condition' => '良好',
                'is_sold' => false,
                'user_id' => 1,
                'category' => 'ファッション,アクセサリー,メンズ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'items/sample2.jpg',
                'condition' => '目立った傷や汚れなし',
                'is_sold' => false,
                'user_id' => 1,
                'category' => '家電',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'items/sample3.jpg',
                'condition' => 'やや傷や汚れあり',
                'is_sold' => false,
                'user_id' => 1,
                'category' => 'キッチン',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラッシックなデザインの革靴',
                'img_url' => 'items/sample4.jpg',
                'condition' => '状態が悪い',
                'is_sold' => false,
                'user_id' => 1,
                'category' => 'ファッション,メンズ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'img_url' => 'items/sample5.jpg',
                'condition' => '良好',
                'is_sold' => false,
                'user_id' => 1,
                'category' => '家電',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'items/sample6.jpg',
                'condition' => '目立った傷や汚れなし',
                'is_sold' => false,
                'user_id' => 2,
                'category' => '家電',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'items/sample7.jpg',
                'condition' => 'やや傷や汚れあり',
                'is_sold' => false,
                'user_id' => 2,
                'category' => 'ファッション,レディース',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'img_url' => 'items/sample8.jpg',
                'condition' => '状態が悪い',
                'is_sold' => false,
                'user_id' => 2,
                'category' => 'キッチン',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'items/sample9.jpg',
                'condition' => '良好',
                'is_sold' => false,
                'user_id' => 2,
                'category' => 'キッチン',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'img_url' => 'items/sample10.jpg',
                'condition' => '目立った傷や汚れなし',
                'is_sold' => false,
                'user_id' => 2,
                'category' => 'ファッション,コスメ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
