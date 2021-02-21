<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\Campaign;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignDeactivationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function a_user_can_deactivate_a_campaign()
    {
        $campaign = Campaign::factory()->create();

        $this->actingAs($this->getAdminUser())->post($this->getDeactivateRoute($campaign));

        $campaign = $campaign->fresh();

        $this->assertEquals(Carbon::now()->format('Y-m-d H:i:s'), $campaign->ends_at);
    }

    /**
     * @test
     */
    public function only_authorized_users_can_deactivate_campaigns()
    {
        $campaign = Campaign::factory()->create();

        $this->actingAs($this->getShopUser())->post($this->getDeactivateRoute($campaign));

        $campaign = $campaign->fresh();

        $this->assertNull($campaign->ends_at);
    }

    private function getDeactivateRoute($campaign)
    {
        return route('admin.campaigns.deactivate', $campaign);
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
