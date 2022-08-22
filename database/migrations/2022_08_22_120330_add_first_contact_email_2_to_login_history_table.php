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
            $table->integer('first_contact_email_2')->default(0);
            $table->datetime('first_contact_date_2')->nullable();
            $table->integer('second_contact_email_2')->default(0);
            $table->datetime('second_contact_date_2')->nullable();
            $table->integer('third_contact_email_2')->default(0);
            $table->datetime('third_contact_date_2')->nullable();
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
