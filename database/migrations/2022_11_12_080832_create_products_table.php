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
            // $table->integer("user_id");
            // $table->string('sku',20);
            $table->string('name',255);
            // $table->integer('stock');
            $table->string('thumbnail',255);
            $table->text('desciption')->nullable();
            $table->double('price')->nullable();
            $table->json("gallery")->nullable();
            $table->date('expired_at')->nullable();
            $table->json('category_id')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_featured')->default(0);
            $table->unsignedTinyInteger('created_by')->nullable();
            $table->unsignedTinyInteger('updated_by')->nullable();
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
