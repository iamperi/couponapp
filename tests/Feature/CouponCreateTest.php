<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function coupons_are_created_when_a_campaign_is_created()
    {
        Campaign::factory()->create();
    }
}
