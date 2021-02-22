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

class CampaignActivationTest extends TestCase
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
    public function a_user_can_activate_a_campaign()
    {
        $campaign = Campaign::factory()->inactive()->create();

        $this->actingAs($this->getAdminUser())->post($this->getPostRoute($campaign));

        $campaign = $campaign->fresh();

        $this->assertTrue($campaign->active);
    }

    /**
     * @test
     */
    public function a_user_can_deactivate_a_campaign()
    {
        $campaign = Campaign::factory()->active()->create();

        $this->actingAs($this->getAdminUser())->post($this->getPostRoute($campaign));

        $campaign = $campaign->fresh();

        $this->assertFalse($campaign->active);
    }

    /**
     * @test
     */
    public function only_authorized_users_can_toggle_campaigns()
    {
        $campaign = Campaign::factory()->create();

        $this->actingAs($this->getShopUser())->post($this->getPostRoute($campaign));

        $campaign = $campaign->fresh();

        $this->assertNull($campaign->ends_at);
    }

    private function getPostRoute($campaign)
    {
        return route('admin.campaigns.toggle', $campaign);
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
