<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Stripe\Stripe;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    //商品購入機能
    public function test_purchase_item(){
        $user = User::find(1);

        Stripe::setApiKey(config('stripe.stripe_secret_key'));
        $response = $this->actingAs($user)->post('/purchase/5',[
            'destination_post_code' => $user->profile->post_code,
            'destination_address' => $user->profile->address,
            'destination_building' => $user->profile->building ?? '',
        ]);

        //stripeの決済画面で表示される文字列
        $response->assertSeeInOrder([
            "Test",
            "Powered by stripe",
        ]);
    }
}
