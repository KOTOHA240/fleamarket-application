<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Tasting\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseMigrations;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }


    //ログイン機能
    public function test_login_user()
    {
        $user = User::find(2);

        $response = $this->post('/login', [
            'email' => "test@example.com",
            'password' => "password1234",
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    //ログインｰｰメアドバリデーション
    public function test_login_user_validate_email()
    {
        $response = $this->post('/login', [
            'emial' => "",
            'password' => "password1234",
        ]);

        $response->assertStatus(302);
        $response-.assertSessionHasErrors('email');

        $errors = session('errors');
        $this->assertEquals('メールアドレスを入力してください', $errors->first('email'));
    }

    //ログインｰｰパスワードバリデーション
    public function test_login_user_validate_password()
    {
        $response = $this->post('/login', [
            'email' => "test@example.com",
            'password' => "",
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        $errors = session('errors');
        $this->assertEquals('パスワードを入力してください', $errors->first('password'));
    }

    //ログイン不一致
    public function test_login_user_validate_user()
    {
        $response = $this->post('/login', [
            'email' => "test2@example.com",
            'password' => "password0000",
        ]);

        $response-> assertStatus(302);
        $response->assertSessionHasErrors('email');

        $errors = session('errors');
        $this->assertEquals('ログイン情報が登録されていません。', $errors->first('email'));
    }
}
