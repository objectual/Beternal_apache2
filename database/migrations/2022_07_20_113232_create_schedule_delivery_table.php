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
        Schema::create('schedule_delivery', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('schedule_media_id');
            $table->foreign('schedule_media_id')->references('id')->on('schedule_media')->onDelete('cascade');
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
        Schema::dropIfExists('schedule_delivery');
    }
};
