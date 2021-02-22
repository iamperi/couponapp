<?php

namespace Database\Factories;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'prefix' => 'COU',
            'coupon_amount' => $this->faker->randomFloat(2, 0, 50),
            'coupon_count' => 100,
            'coupon_validity' => 48,
            'limit_per_person' => 2,
            'starts_at' => Carbon::now()->format('d/m/Y H:i'),
        ];
    }

    public function active()
    {
        return $this->state(function($attributes) {
            return [
                'active' => true
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function($attributes) {
            return [
                'active' => false
            ];
        });
    }
}
