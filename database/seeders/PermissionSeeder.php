<?php

namespace Database\Seeders;

use App\Constants;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => Constants::ADMIN_ROLE]);
        $shop = Role::create(['name' => Constants::SHOP_ROLE]);

        $accessAdmin = Permission::create(['name' => Constants::ACCESS_ADMIN]);
        $createShops = Permission::create(['name' => Constants::CREATE_SHOPS]);
        $createCampaigns = Permission::create(['name' => Constants::CREATE_CAMPAIGNS]);
        $editCampaigns = Permission::create(['name' => Constants::EDIT_CAMPAIGNS]);
        $validateCoupons = Permission::create(['name' => Constants::VALIDATE_COUPONS]);
        $payCoupons = Permission::create(['name' => Constants::PAY_COUPONS]);


        $admin->syncPermissions([
            $accessAdmin,
            $createShops,
            $createCampaigns,
            $editCampaigns,
            $payCoupons
        ]);

        $shop->syncPermissions([
            $accessAdmin,
            $validateCoupons
        ]);

    }
}
