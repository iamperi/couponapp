<?php

namespace Tests\Unit;

use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
