<?php

namespace Tests\Feature;

use App\Mail\CouponRequested;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CouponRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $seed = true;

    private $postRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRoute = route('coupons.assign');
    }

    /**
     * @test
     */
    public function a_user_can_access_the_request_coupon_form()
    {
        $this->withoutExceptionHandling();

        $response =$this->get(route('home'));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function a_user_can_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData();

        $this->post($this->postRoute, $data);

        $user = User::where('dni', $data['dni'])->first();

        $this->assertDatabaseHas('coupons', [
            'campaign_id' => 1,
            'user_id' => $user->id
        ]);
    }

    /**
     * @test
     */
    public function a_name_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'name' => ''
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('name');
    }

    /**
     * @test
     */
    public function a_last_name_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'last_name' => ''
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('last_name');
    }

    /**
     * @test
     */
    public function a_dni_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'dni' => ''
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('dni');
    }

    /**
     * @test
     */
    public function dni_cannot_be_larger_than_9_characters_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'dni' => '123456789Z'
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('dni');
    }

    /**
     * @test
     */
    public function dni_has_to_be_alphanumeric_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'dni' => '1234567-Z'
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('dni');
    }

    /**
     * @test
     */
    public function a_phone_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'phone' => ''
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('phone');
    }

    /**
     * @test
     */
    public function phone_cannot_be_larger_than_9_characters_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'phone' => '1234567890'
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('phone');
    }

    /**
     * @test
     */
    public function an_email_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'email' => ''
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function a_valid_email_is_required_to_request_a_coupon()
    {
//        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = $this->getUserData([
            'email' => 'invalidemail'
        ]);

        $response = $this->post($this->postRoute, $data);

        $response->assertSessionHasErrorsIn('email');
    }

    /**
     * @test
     */
    public function a_user_cannot_request_more_coupons_than_the_limit_defined_in_the_campaign()
    {
        Campaign::truncate();
        $campaign = Campaign::factory()->create([
            'limit_per_person' => 1,
            'active' => true
        ]);

        $data = $this->getUserData();

        $this->post($this->postRoute, $data);

        $response = $this->followingRedirects()->post($this->postRoute, $data);

        $response->assertSee(__('You have reached the coupon limit for this campaign'));
    }

    /**
     * @test
     */
    public function coupons_expires_at_value_is_updated_when_a_coupon_is_requested()
    {
        $campaign = Campaign::factory()->create();

        $data = $this->getUserData();

        $this->post($this->postRoute, $data);

        $user = User::where('dni', $data['dni'])->first();

        $coupon = $user->coupons->first();

        $this->assertEquals(Carbon::now()->addHours($campaign->coupon_validity)->format('Y-m-d H:i:s'), $coupon->expires_at);
    }

    /**
     * @test
     */
    public function users_name_and_last_name_are_formatted_before_saving()
    {
        Campaign::factory()->create();

        $data = $this->getUserData([
            'name' => 'jose antOnio',
            'last_name' => 'López de mendiguren '
        ]);

        $this->post($this->postRoute, $data);

        $user = User::where('dni', $data['dni'])->first();

        $this->assertEquals('Jose Antonio', $user->name);
        $this->assertEquals('López De Mendiguren', $user->last_name);
    }

    /**
     * @test
     */
    public function users_dni_is_uppercased_before_saving()
    {
        Campaign::factory()->create();

        $data = $this->getUserData([
            'dni' => '12345678z'
        ]);

        $this->post($this->postRoute, $data);

        $user = User::where('dni', '12345678Z')->first();

        $this->assertNotNull($user);
    }

    /**
     * @test
     */
    public function an_email_is_sent_when_a_user_requests_a_coupon()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        Campaign::factory()->create();

        $data = $this->getUserData();

        $this->post($this->postRoute, $data);

        Mail::assertSent(CouponRequested::class);
    }

    /**
     * @test
     */
    public function cannot_assign_a_coupon_if_a_campaign_is_maxed_out()
    {
        $campaign = Campaign::factory()->create();

        foreach($campaign->coupons as $coupon) {
            $coupon->used_at = Carbon::now();
            $coupon->user_id = User::factory()->create()->id;
            $coupon->save();
        }

        $data = $this->getUserData();

        $response = $this->followingRedirects()->post($this->postRoute, $data);

        $response->assertSee(__('Sorry... There are no coupons left for this campaign'));
    }

    /**
     * @test
     */
    public function a_new_coupon_is_injected_when_a_campaign_is_maxed_out_but_there_are_slots_available()
    {
        $campaign = Campaign::factory()->create();

        foreach($campaign->coupons as $index => $coupon) {
            $coupon->user_id = User::factory()->create()->id;
            if($index == 0) {
                $coupon->expires_at = Carbon::now()->subDay();
            }
            $coupon->save();
        }

        $couponsBefore = Coupon::where('campaign_id', $campaign->id)->count();

        $response = $this->followingRedirects()->post($this->postRoute, $this->getUserData());

        $couponsAfter = Coupon::where('campaign_id', $campaign->id)->count();

        $this->assertEquals($couponsBefore + 1, $couponsAfter);
    }

    private function getUserData($data = [])
    {
        return array_merge([
            'campaign_id' => 1,
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'dni' => fakeDni(),
            'phone' => $this->faker->randomNumber(9),
            'email' => $this->faker->email
        ], $data);
    }
}
