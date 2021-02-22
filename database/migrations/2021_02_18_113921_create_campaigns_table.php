<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('prefix', 3);
            $table->double('coupon_amount')->comment('Coupon discount amount');
            $table->unsignedInteger('coupon_count')->comment('Number of coupons that will be available');
            $table->unsignedInteger('coupon_validity')->comment('In hours');
            $table->unsignedInteger('limit_per_person')->comment('Max. number of coupons that a person can get');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
