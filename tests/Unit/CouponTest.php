<?php

namespace Tests\Unit;

use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_assign_a_user_with_a_coupon()
    {
        $user = User::factory()->create();

        Campaign::factory()->create();

        $coupon = Coupon::first();

        $coupon->assignTo($user);

        $coupon = $coupon->fresh();

        $this->assertNotNull($coupon->user_id);
    }

    /**
     * @test
     */
    public function used_filter_returns_only_authenticated_shops_coupons()
    {
        $this->seed();

        $shop1 = Shop::factory()->create();
        $shop2 = Shop::factory()->create();

        $campaign = Campaign::factory()->create();

        $this->actingAs($shop1->user);

        $campaign->coupons[0]->assignTo(User::factory()->create());
        $campaign->coupons[0]->validate();
        $campaign->coupons[1]->assignTo(User::factory()->create());
        $campaign->coupons[1]->validate();

        $this->actingAs($shop2->user);

        $campaign->coupons[2]->assignTo(User::factory()->create());
        $campaign->coupons[2]->validate();
        $campaign->coupons[3]->assignTo(User::factory()->create());
        $campaign->coupons[3]->validate();

        $coupons = Coupon::filterUsed();

        $this->assertCount(2, $coupons);
    }
}
