<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CampaignCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $storeRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeRoute = route('admin.campaigns.store');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_campaign()
    {
        $this->withoutExceptionHandling();

        $user = $this->getAdminUser();

        $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData());

        $this->assertDatabaseHas('campaigns', [
            'name' => 'Christmas'
        ]);
    }

    /**
     * @test
     */
    public function only_an_authorized_user_can_create_campaigns()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData());

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function a_name_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['name' => '']));

        $response->assertSessionHasErrorsIn('name');
    }

    /**
     * @test
     */
    public function a_name_cannot_be_larger_than_64_characters_to_create_a_shop()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['name' => Str::random(65)]));

        $response->assertSessionHasErrorsIn('name');
    }

    /**
     * @test
     */
    public function a_prefix_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['prefix' => '']));

        $response->assertSessionHasErrorsIn('prefix');
    }

    /**
     * @test
     */
    public function prefix_length_must_be_exactly_3_characters()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['prefix' => 'ab']));

        $response->assertSessionHasErrorsIn('prefix');

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['prefix' => 'abcd']));

        $response->assertSessionHasErrorsIn('prefix');
    }

    /**
     * @test
     */
    public function a_coupon_amount_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_amount' => '']));

        $response->assertSessionHasErrorsIn('coupon_amount');
    }

    /**
     * @test
     */
    public function a_numeric_coupon_amount_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_amount' => 'amount']));

        $response->assertSessionHasErrorsIn('coupon_amount');
    }

    /**
     * @test
     */
    public function the_coupon_amount_must_be_greater_than_zero_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_amount' => '0']));

        $response->assertSessionHasErrorsIn('coupon_amount');
    }

    /**
     * @test
     */
    public function a_coupon_count_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_count' => '']));

        $response->assertSessionHasErrorsIn('coupon_count');
    }

    /**
     * @test
     */
    public function a_numeric_coupon_count_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_count' => 'amount']));

        $response->assertSessionHasErrorsIn('coupon_count');
    }

    /**
     * @test
     */
    public function the_coupon_count_must_be_greater_than_zero_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_count' => '0']));

        $response->assertSessionHasErrorsIn('coupon_count');
    }

    /**
     * @test
     */
    public function the_coupon_count_must_be_an_integer_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_count' => '1.5']));

        $response->assertSessionHasErrorsIn('coupon_count');
    }

    /**
     * @test
     */
    public function a_coupon_validity_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_validity' => '']));

        $response->assertSessionHasErrorsIn('coupon_validity');
    }

    /**
     * @test
     */
    public function a_numeric_coupon_validity_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_validity' => 'amount']));

        $response->assertSessionHasErrorsIn('coupon_validity');
    }

    /**
     * @test
     */
    public function the_coupon_validity_must_be_an_integer_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['coupon_validity' => '1.5']));

        $response->assertSessionHasErrorsIn('coupon_validity');
    }

    /**
     * @test
     */
    public function a_limit_per_person_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['limit_per_person' => '']));

        $response->assertSessionHasErrorsIn('limit_per_person');
    }

    /**
     * @test
     */
    public function a_numeric_limit_per_person_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['limit_per_person' => 'amount']));

        $response->assertSessionHasErrorsIn('limit_per_person');
    }

    /**
     * @test
     */
    public function the_limit_per_person_must_be_an_integer_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['limit_per_person' => '1.5']));

        $response->assertSessionHasErrorsIn('limit_per_person');
    }

    /**
     * @test
     */
    public function a_starts_at_datetime_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['starts_at' => '']));

        $response->assertSessionHasErrorsIn('starts_at');
    }

    /**
     * @test
     */
    public function a_valid_starts_at_datetime_is_required_to_create_a_campaign()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['starts_at' => '2021/09/34 14:49']));

        $response->assertSessionHasErrorsIn('starts_at');
    }

    /**
     * @test
     */
    public function ends_at_datetime_can_be_null()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['ends_at' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function when_it_is_present_the_ends_at_datetime_must_be_valid()
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->post($this->storeRoute, $this->getCampaignData(['ends_at' => '2021/09/34 14:49']));

        $response->assertSessionHasErrorsIn('ends_at');
    }

    private function getCampaignData($data = [])
    {
        return array_merge([
            'name' => 'Christmas',
            'prefix' => 'CHR',
            'coupon_amount' => '10',
            'coupon_count' => '1000',
            'coupon_validity' => '48',
            'limit_per_person' => '2',
            'starts_at' => '20/12/2021 10:00:00',
            'ends_at' => '06/01/2021 00:00:00',
        ], $data);
    }

    private function getAdminUser()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::ADMIN_ROLE);
        return $user;
    }
}
