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
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('last_name')->nullable()->after('name');
        //     $table->string('phone_number')->nullable()->after('email');
        //     $table->string('address')->nullable()->after('phone_number');
        //     $table->string('profile_image')->nullable()->after('address');
        //     $table->integer('role_id')->unsigned()->after('profile_image');
        //     $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        // });
    }
};
