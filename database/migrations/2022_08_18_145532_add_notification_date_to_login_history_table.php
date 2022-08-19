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
        Schema::table('login_history', function (Blueprint $table) {
            $table->datetime('notification_date')->nullable();
            $table->integer('user_first_email')->default(0);
            $table->datetime('first_email_date')->nullable();
            $table->integer('user_second_email')->default(0);
            $table->datetime('second_email_date')->nullable();
            $table->integer('first_contact_email')->default(0);
            $table->datetime('first_contact_date')->nullable();
            $table->integer('second_contact_email')->default(0);
            $table->datetime('second_contact_date')->nullable();
            $table->integer('third_contact_email')->default(0);
            $table->datetime('third_contact_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_history', function (Blueprint $table) {
            //
        });
    }
};
