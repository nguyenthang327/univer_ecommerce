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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->unique();
            $table->string('user_name',100)->unique();
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->unsignedTinyInteger('gender')->nullable();
            $table->string('phone',15);
            $table->string('identity_card', 200);
            $table->date('birthday')->nullable();
            $table->string('password',200);
            $table->string('avatar', 500)->nullable();
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
        Schema::dropIfExists('admins');
    }
};
