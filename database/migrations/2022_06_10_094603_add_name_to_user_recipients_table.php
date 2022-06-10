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
        Schema::table('user_recipients', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('country_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('profile_image')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('state_province_id');
            $table->foreign('state_province_id')->references('id')->on('state_province')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('zip_postal_code')->nullable();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_recipients', function (Blueprint $table) {
            //
        });
    }
};
