<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $adminRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRoute = route('admin.index');
    }

    /**
     * @test
     */
    public function admin_users_can_access_admin_panel()
    {
        $this->withoutExceptionHandling();

        $user = User::role(Constants::ADMIN_ROLE)->first();

        $response = $this->actingAs($user)->get($this->adminRoute);

        $response->assertRedirect(route('admin.shops.index'));
    }

    /**
     * @test
     */
    public function shop_users_can_access_admin_panel()
    {
        $this->withoutExceptionHandling();

        $user = User::role(Constants::SHOP_ROLE)->first();

        $response = $this->actingAs($user)->get($this->adminRoute);

        $response->assertRedirect(route('admin.coupons.validation.index'));
    }

    /**
     * @test
     */
    public function unauthenticated_users_can_not_access_admin_panel()
    {
//        $this->withoutExceptionHandling();

        $response = $this->get($this->adminRoute);

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function only_authorized_users_can_access_admin_panel()
    {
//        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($this->adminRoute);

        $response->assertForbidden();
    }
}
