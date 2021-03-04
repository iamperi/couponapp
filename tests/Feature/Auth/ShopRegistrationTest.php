<?php

namespace Tests\Feature\Auth;

use App\Models\Shop;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * @test
     */
    public function a_shop_with_valid_token_can_access_the_registration_form()
    {
        $this->withoutExceptionHandling();

        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->get($this->createRoute($token));

        $response->assertStatus(200);

        $response->assertViewIs('auth.shops.register');
    }

    /**
     * @test
     */
    public function user_with_invalid_token_sees_an_error_message()
    {
        $response = $this->followingRedirects()->get($this->createRoute('invalidtoken'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertSee(__('Invalid token'));
    }

    /**
     * @test
     */
    public function user_without_token_sees_the_404_error_not_found_page()
    {
        $response = $this->get($this->createRoute(NULL));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function new_shops_can_register_with_valid_data()
    {
        $this->withoutExceptionHandling();

        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $data = $this->data($token, [
            'shop_name' => $shop->name
        ]));

        $this->assertDatabaseHas('shops', [
            'name' => $data['shop_name']
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $shop->user->email,
            'phone' => $data['phone']
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('admin.index'));
    }

    /**
     * @test
     */
    public function a_token_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data(''));

        $response->assertSessionHasErrors('token');
    }

    /**
     * @test
     */
    public function a_valid_token_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data('invalidtoken'));

        $response->assertSessionHasErrors('token');
    }

    /**
     * @test
     */
    public function a_shop_name_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['shop_name' => '']));

        $response->assertSessionHasErrors('shop_name');
    }

    /**
     * @test
     */
    public function a_username_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['username' => '']));

        $response->assertSessionHasErrors('username');
    }

    /**
     * @test
     */
    public function a_unique_username_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['username' => User::first()->username]));

        $response->assertSessionHasErrors('username');
    }

    /**
     * @test
     */
    public function an_email_is_not_required_to_create_a_shop_account()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['email' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function if_an_email_is_not_provided_the_email_is_automatically_grabbed_from_the_users_table()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $email = $shop->user->email;

        $this->post($this->storeRoute(), $this->data($token, ['email' => '']));

        $this->assertEquals($email, $shop->fresh()->user->fresh()->email);
    }

    /**
     * @test
     */
    public function a_phone_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['phone' => '']));

        $response->assertSessionHasErrors('phone');
    }

    /**
     * @test
     */
    public function a_unique_phone_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $user = User::first();
        $user->phone = '123456';
        $user->save();


        $response = $this->post($this->storeRoute(), $this->data($token, ['phone' => '123456']));

        $response->assertSessionHasErrors('phone');
    }

    /**
     * @test
     */
    public function a_password_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['password' => '']));

        $response->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function a_password_confirmation_is_required_to_register_a_new_shop()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $response = $this->post($this->storeRoute(), $this->data($token, ['password_confirmation' => '']));

        $response->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function shops_registration_token_is_set_to_null_when_a_shop_is_registered()
    {
        $shop = Shop::factory()->create();
        $token = $shop->generateRegistrationToken();

        $this->post($this->storeRoute(), $this->data($token));

        $this->assertNull($shop->fresh()->registration_token);
    }

    private function data($token, $data = [])
    {
        return array_merge([
            'token' => $token,
            'shop_name' => 'Test Shop',
            'username' => 'test.shop',
            'email' => 'test@shop.com',
            'phone' => '666000111',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $data);
    }

    private function createRoute($token)
    {
        return route('shops.register.create', ['token' => $token]);
    }

    private function storeRoute()
    {
        return route('shops.register.store');
    }
}
