<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected $verificationRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->verificationRoute = route('admin.coupons.verify');
    }

    /**
     * @test
     */
    public function a_shop_can_verify_a_valid_coupon()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo(User::factory()->create());

        $response = $this->actingAs($this->getShopUser())
            ->followingRedirects()
            ->post($this->verificationRoute, [
                'code' => $coupon->code
            ]);

        $response->assertSee(__('Coupon is valid'));
    }

    /**
     * @test
     */
    public function a_code_is_required_to_verify_a_coupon()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo(User::factory()->create());

        $response = $this->actingAs($this->getShopUser())
            ->post($this->verificationRoute, [
                'code' => ''
            ]);

        $response->assertSessionHasErrorsIn('code');
    }

    /**
     * @test
     */
    public function only_authorized_users_can_verify_coupons()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo(User::factory()->create());

        $response = $this->actingAs($this->getAdminUser())
            ->followingRedirects()
            ->post($this->verificationRoute, [
                'code' => $coupon->code
            ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function verification_fails_when_a_coupon_is_expired()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo(User::factory()->create());

        $coupon->expires_at = Carbon::now()->subDay();
        $coupon->save();

        $response = $this->actingAs($this->getShopUser())
            ->followingRedirects()
            ->post($this->verificationRoute, [
                'code' => $coupon->code
            ]);

        $response->assertSee(__('Coupon is expired'));
    }

    /**
     * @test
     */
    public function verification_fails_when_a_coupon_is_not_assigned_to_a_user()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $response = $this->actingAs($this->getShopUser())
            ->followingRedirects()
            ->post($this->verificationRoute, [
                'code' => $coupon->code
            ]);

        $response->assertSee(__('Coupon is not assigned to any user'));
    }

    /**
     * @test
     */
    public function verification_fails_when_a_coupon_is_already_used()
    {
        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo(User::factory()->create());

        $coupon->used_at = Carbon::now();
        $coupon->save();

        $response = $this->actingAs($this->getShopUser())
            ->followingRedirects()
            ->post($this->verificationRoute, [
                'code' => $coupon->code
            ]);

        $response->assertSee(__('Coupon is already used'));
    }

    private function getAdminUser()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::ADMIN_ROLE);
        return $user;
    }

    private function getShopUser()
    {
        $shop = Shop::factory()->create();
        return $shop->user;
    }
}
