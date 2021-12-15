<?php

namespace Tests\Feature;

use App\Constants;
use App\Mail\ShopRegistration;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ShopCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $storeRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeRoute = route('admin.shops.store');
    }

    /**
     * @test
     */
    public function admin_can_create_a_shop()
    {
        $user = $this->getAdminUser();

        $this->actingAs($user)->post($this->storeRoute, $data = $this->data());

        $this->assertDatabaseHas('users', [
            'username' => $data['email'],
            'email' => $data['email']
        ]);

        $shopUser = User::where('username', $data['email'])->first();

        $this->assertTrue($shopUser->hasRole(Constants::SHOP_ROLE));

        $this->assertDatabaseHas('shops', [
            'user_id' => $shopUser->id,
            'name' => 'Starbucks'
        ]);
    }

    /**
     * @test
     */
    public function a_success_message_is_shown_when_a_shop_is_created()
    {
        $user = $this->getAdminUser();

        $response = $this->followingRedirects()->actingAs($user)->post($this->storeRoute, $this->data());

        $response->assertSee(__('Shop created successfully'));
    }

    /**
     * @test
     */
    public function only_an_authorized_user_can_create_shops()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->data());

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function a_name_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['name' => '']));

        $response->assertSessionHasErrorsIn('name');
    }

//    /**
//     * @test
//     */
//    public function a_phone_is_required_to_create_a_shop()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['phone' => '']));
//
//        $response->assertSessionHasErrorsIn('phone');
//    }

//    /**
//     * @test
//     */
//    public function a_phone_cannot_be_larger_than_9_characters_to_create_a_shop()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['phone' => '1234567890']));
//
//        $response->assertSessionHasErrorsIn('phone');
//    }

//    /**
//     * @test
//     */
//    public function a_phone_has_to_be_unique()
//    {
//        $user = $this->getAdminUser();
//
//        $newUser = User::factory()->create(['phone' => '123456']);
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['phone' => $newUser->phone]));
//
//        $response->assertSessionHasErrorsIn('phone');
//    }

    /**
     * @test
     */
    public function an_email_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['email' => '']));

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function a_valid_email_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['email' => 'invalidemail']));

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function an_email_has_to_be_unique()
    {
        // $user = $this->getAdminUser();

        // $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['email' => $user->email]));

        // $response->assertSessionHasErrorsIn('email');
    }

//    /**
//     * @test
//     */
//    public function a_username_is_required_to_create_a_shop()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['username' => '']));
//
//        $response->assertSessionHasErrorsIn('username');
//    }

//    /**
//     * @test
//     */
//    public function a_username_cannot_be_larger_than_50_characters_to_create_a_shop()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['username' => 'this.is.a.very.very.very.very.very.very.long.username']));
//
//        $response->assertSessionHasErrorsIn('username');
//    }

//    /**
//     * @test
//     */
//    public function a_username_has_to_be_unique()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['username' => $user->username]));
//
//        $response->assertSessionHasErrorsIn('username');
//    }

//    /**
//     * @test
//     */
//    public function a_password_confirmation_is_required_to_create_a_shop()
//    {
//        $user = $this->getAdminUser();
//
//        $response = $this->actingAs($user)->post($this->storeRoute, $this->data(['password_confirmation' => '']));
//
//        $response->assertSessionHasErrorsIn('password');
//    }

    /**
     * @test
     */
    public function a_registration_token_is_generated_when_a_shop_is_created()
    {
        $this->actingAs($this->getAdminUser())->post($this->storeRoute, $data = $this->data());

        $shop = Shop::where('name', $data['name'])->first();

        $this->assertNotNull($shop->registration_token);
    }

    /**
     * @test
     */
    public function an_email_is_sent_to_the_store()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $this->actingAs($this->getAdminUser())->post($this->storeRoute, $data = $this->data());

        Mail::assertSent(ShopRegistration::class);
    }

    private function data($data = [])
    {
        return array_merge([
            'name' => 'Starbucks',
            'email' => 'hello@starbucks.com',
//            'phone' => '600123456',
//            'username' => 'starbucks',
//            'password' => 'password',
//            'password_confirmation' => 'password'
        ], $data);
    }

    private function getAdminUser()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::ADMIN_ROLE);
        return $user;
    }
}
