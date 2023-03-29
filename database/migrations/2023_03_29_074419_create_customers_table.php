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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('user_name', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('password', 200)->nullable();
            $table->string('phone', 15)->nullable();
            $table->date('birthday')->nullable();
            $table->string('address',500)->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->string('avatar',500)->nullable();
            $table->string('facebook_id', 60)->nullable();
            $table->string('google_id', 60)->nullable();
            $table->unsignedInteger('prefecture_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('commune_id')->nullable();
            $table->unsignedInteger('language_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
};
