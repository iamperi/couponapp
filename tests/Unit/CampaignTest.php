<?php

namespace Tests\Unit;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_only_active_campaigns()
    {
        $this->withoutExceptionHandling();

        // Create 5 active campaigns
        Campaign::factory()->count(5)->create();
        // Create 5 inactive campaigns
        Campaign::factory()->count(5)->inactive()->create();

        $campaigns = Campaign::active()->get();

        $this->assertCount(5, $campaigns);
    }
}
