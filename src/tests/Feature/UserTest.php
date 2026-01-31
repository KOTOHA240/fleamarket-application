<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    //ログアウト機能
    public function test_logout_user(){
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    //ユーザー情報取得
    public function test_get_profile(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSeeInOrder([
            'ジェーン・ドゥ',
            '1234567',
            '東京都千代田区千駄ヶ谷'
        ]);
    }

    //ユーザー情報変更
    public function test_change_profile(){
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/mypage/profile',[
            'name' => "変更後ネーム",
            'post_code' => "98765432",
            'address' => "東京都台東区浅草2-3-1",
            'building' => "浅草寺",
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas( Profile::class, [
            'user_id' => 1,
            'post_code' => "98765432",
            'address' => "東京都台東区浅草2-3-1",
            'building' => "浅草寺",
        ]);
    }

    //出品情報登録
    public function test_listing_item(){
        $user = User::find(1);

        Storage::fake('local');
        $image = UploadedFile::fake()->create('test_item.png', 150);

        $response = $this->actingAs($user)->post('/sell',[
            'img_url' => $image,
            'name' => "テストアイテム",
            'price' => 5000,
            'brand' => '',
            'description' => "テストテストテストテスト",
            'categories' => [2,3,4],
            'condition_id' => 4,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas( Item::class, [
            'name' => "テストアイテム",
            'price' => 5000,
            'description' => "テストテストテストテスト",
            'user_id' => 1,
            'condition_id' => 4,
        ]);

        Storage::disk('local')->assertExists('storage/app/public/items' .$image->hasName());
    }
}
