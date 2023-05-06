<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->integer('status')->default(0); // awaiting_payment
            $table->integer('payment_method')->default(0); // cash_on_delivery
            $table->string('full_name', 100);
            $table->string('phone', 15);
            $table->unsignedInteger('prefecture_id');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('commune_id');
            $table->string('address',255);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
