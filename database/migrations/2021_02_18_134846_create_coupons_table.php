<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('shop_id')->nullable()->constrained();
            $table->string('code', 9)->unique()->comment('A code is formed by a 3 letter prefix (CHR) and a 6 char random alphanumeric string');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->double('amount');
            $table->dateTime('used_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('payed_at')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
