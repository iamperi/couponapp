<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function a_user_can_request_a_coupon()
    {
        $this->withoutExceptionHandling();

        Campaign::factory()->create();

        $data = [
            'campaign_id' => 1,
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'dni' => fakeDni(),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email
        ];

        $this->post($this->postRoute, $data);

        $user = User::where('dni', $data['dni'])->first();

        $this->assertDatabaseHas('coupons', [
            'campaign_id' => 1,
            'user_id' => $user->id
        ]);
    }
}
