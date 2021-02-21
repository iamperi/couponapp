<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
           'username' => 'iamadmin',
           'email' => 'aloadavid@gmail.com',
           'password' => Hash::make('password')
        ]);
        $user->assignRole(Constants::ADMIN_ROLE);

        $shop = Shop::factory()->create();

        $shopUser = User::create([
            'username' => 'iamshop',
            'email' => 'me@iamshop.com',
            'password' => Hash::make('password')
        ]);
        $shopUser->assignRole(Constants::SHOP_ROLE);
        $shop->user()->associate($shopUser)->save();
    }
}
