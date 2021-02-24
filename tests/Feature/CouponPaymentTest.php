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

class CouponPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        Campaign::factory()->create();

        $this->coupon = Coupon::first();

        $this->coupon->assignTo(User::factory()->create());

        $this->coupon->validate();

        $this->coupon->used_at = Carbon::now();
        $this->coupon->shop_id = Shop::first()->id;
        $this->coupon->save();

        $this->coupon = $this->coupon->fresh();
    }

    /**
     * @test
     */
    public function admin_can_mark_coupon_as_payed()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals(Carbon::now()->format('Y-m-d H:i:s'), $this->coupon->fresh()->payed_at);
    }

    /**
     * @test
     */
    public function admin_can_mark_coupon_as_unpayed()
    {
//        $this->withoutExceptionHandling();

        $this->coupon->payed_at = Carbon::now();
        $this->coupon->save();

        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals(NULL, $this->coupon->fresh()->payed_at);
    }

    /**
     * @test
     */
    public function can_not_mark_as_payed_an_invalidated_coupon()
    {
        $this->coupon->used_at = NULL;
        $this->coupon->save();

        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals(NULL, $this->coupon->fresh()->payed_at);
    }

    /**
     * @test
     */
    public function shops_payed_amount_is_updated_when_a_coupon_is_marked_as_payed()
    {
        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals($this->coupon->amount, $this->coupon->shop->payed_amount);
    }

    /**
     * @test
     */
    public function shops_due_amount_is_updated_when_a_coupon_is_marked_as_payed()
    {
        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals($this->coupon->amount, $this->coupon->shop->payed_amount);
    }

    /**
     * @test
     */
    public function shops_payed_amount_is_updated_when_a_coupon_is_marked_as_unpayed()
    {
        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $newPayedAmount = $this->coupon->shop->payed_amount - $this->coupon->amount;

        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals($newPayedAmount, $this->coupon->fresh()->shop->payed_amount);
    }

    /**
     * @test
     */
    public function shops_due_amount_is_updated_when_a_coupon_is_marked_as_unpayed()
    {
        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $newDueAmount = $this->coupon->shop->due_amount + $this->coupon->amount;

        $this->actingAs($this->getAdminUser())->post($this->getPayRoute($this->coupon));

        $this->assertEquals($newDueAmount, $this->coupon->fresh()->shop->due_amount);
    }

    /**
     * @test
     */
    public function only_admin_user_can_mark_coupon_as_payed()
    {
        $response = $this->actingAs($this->getShopUser())->post($this->getPayRoute($this->coupon));

        $response->assertForbidden();
    }

    private function getPayRoute($coupon)
    {
        return route('admin.coupons.payment.update', $coupon);
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
