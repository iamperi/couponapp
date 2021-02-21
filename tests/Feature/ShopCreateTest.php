<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function a_user_can_create_a_shop()
    {
        $this->withoutExceptionHandling();

        $user = $this->getAdminUser();

        $this->actingAs($user)->post($this->storeRoute, $this->getShopData());

        $this->assertDatabaseHas('users', [
            'phone' => '600123456',
            'email' => 'hello@starbucks.com',
            'username' => 'starbucks',
        ]);

        $shopUser = User::where('username', 'starbucks')->first();

        $this->assertTrue($shopUser->hasRole(Constants::SHOP_ROLE));

        $this->assertDatabaseHas('shops', [
            'user_id' => $shopUser->id,
            'name' => 'Starbucks'
        ]);
    }

    /**
     * @test
     */
    public function only_an_authorized_user_can_create_shops()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData());

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function a_name_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['name' => '']));

        $response->assertSessionHasErrorsIn('name');
    }

    /**
     * @test
     */
    public function a_phone_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['phone' => '']));

        $response->assertSessionHasErrorsIn('phone');
    }

    /**
     * @test
     */
    public function a_phone_cannot_be_larger_than_9_characters_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['phone' => '1234567890']));

        $response->assertSessionHasErrorsIn('phone');
    }

    /**
     * @test
     */
    public function an_email_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['email' => '']));

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function a_valid_email_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['email' => 'invalidemail']));

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function a_username_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['username' => '']));

        $response->assertSessionHasErrorsIn('username');
    }

    /**
     * @test
     */
    public function a_username_cannot_be_larger_than_50_characters_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['username' => 'this.is.a.very.very.very.very.very.very.long.username']));

        $response->assertSessionHasErrorsIn('username');
    }

    /**
     * @test
     */
    public function a_password_confirmation_is_required_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getShopData(['password_confirmation' => '']));

        $response->assertSessionHasErrorsIn('password');
    }

    private function getShopData($data = [])
    {
        return array_merge([
            'name' => 'Starbucks',
            'phone' => '600123456',
            'email' => 'hello@starbucks.com',
            'username' => 'starbucks',
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $data);
    }

    private function getAdminUser()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::ADMIN_ROLE);
        return $user;
    }
}
