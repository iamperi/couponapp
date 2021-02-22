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

    private $coupon;

    protected function setUp(): void
    {
        parent::setUp();

        $citizen = User::factory()->create();

        Campaign::factory()->create();

        $this->coupon = Coupon::first();
        $this->coupon->assignTo($citizen);
    }

    /**
     * @test
     */
    public function a_user_can_verify_a_coupon()
    {
//        $this->withoutExceptionHandling();

        $this->actingAs($this->getShopUser())->post($this->getVerifyRouteFor($this->coupon));

        $coupon = $this->coupon->fresh();
        $this->assertNotNull($coupon->used_at);
    }

    /**
     * @test
     */
    public function only_authorized_users_can_verify_coupon_codes()
    {
        $user = $this->getAdminUser(); // Admin users can't verify coupons

        $response = $this->actingAs($user)->post($this->getVerifyRouteFor($this->coupon));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function a_coupon_is_assigned_to_a_shop_when_it_is_verified()
    {
        $this->withoutExceptionHandling();

        $shopUser = $this->getShopUser();

        $this->actingAs($shopUser)->post($this->getVerifyRouteFor($this->coupon));

        $coupon = $this->coupon->fresh();
        $this->assertEquals($shopUser->shop->id, $coupon->shop_id);
    }

    /**
     * @test
     */
    public function can_only_verify_coupons_assigned_to_a_user()
    {
        $this->coupon->user_id = NULL;
        $this->coupon->save();

        $this->actingAs($this->getShopUser())->post($this->getVerifyRouteFor($this->coupon));

        $coupon = $this->coupon->fresh();
        $this->assertNull($coupon->used_at);
    }

    /**
     * @test
     */
    public function an_expired_coupon_can_not_be_validated()
    {
        $this->coupon->expires_at = Carbon::now()->subDay();
        $this->coupon->save();

        $this->actingAs($this->getShopUser())->post($this->getVerifyRouteFor($this->coupon));

        $coupon = $this->coupon->fresh();
        $this->assertNull($coupon->used_at);
    }

    /**
     * @test
     */
    public function a_coupon_can_only_be_used_once()
    {
        $this->actingAs($this->getShopUser())->post($this->getVerifyRouteFor($this->coupon));

        $response = $this->actingAs($this->getShopUser())->post($this->getVerifyRouteFor($this->coupon));

        $response->assertJsonFragment([
            'status' => 'error'
        ]);
    }

    private function getVerifyRouteFor($coupon)
    {
        return route('admin.coupons.validation.store', ['coupon' => $coupon]);
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
