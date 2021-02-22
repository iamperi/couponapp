<?php

namespace Database\Factories;

use App\Constants;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        $user->assignRole(Constants::SHOP_ROLE)->save();
        return [
            'user_id' => $user->id,
            'name' => $this->faker->word
        ];
    }
}
