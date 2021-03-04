<?php

namespace Tests\Feature;

use App\Constants;
use App\Mail\ShopRegistration;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendRegistrationEmailTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * @test
     */
    public function admin_can_resend_registration_email_to_a_shop()
    {
        Mail::fake();

        $shop = Shop::first();

        $this->actingAs($this->getAdminUser())->get(route('admin.shops.send_registration_email', $shop));

        Mail::assertSent(ShopRegistration::class);
    }

    private function getAdminUser()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::ADMIN_ROLE);
        return $user;
    }
}
