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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug',500)->unique();
            $table->string('sku')->nullable();
            $table->decimal('price', 12)->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->string('name',255);
            $table->text('description')->nullable();
            $table->json("gallery")->nullable();
            // $table->datetime('expired_at')->nullable();
            $table->unsignedFloat('discount')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('product_type')->default(0);
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('created_by_user_id')->nullable();
            $table->unsignedInteger('updated_by_user_id')->nullable();
            $table->unsignedInteger('created_by_admin_id')->nullable();
            $table->unsignedInteger('updated_by_admin_id')->nullable();
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
        Schema::dropIfExists('products');
    }
};
