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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('site_id');
            $table->string('external_booking_id');
            $table->string('cabin_id');
            $table->string('guest_id');
            $table->string('guest_type_id')->nullable();
            $table->string('adults');
            $table->string('children');
            $table->string('infent');
            $table->string('guest_f_name')->nullable();
            $table->string('guest_l_name')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('checkin');
            $table->dateTime('checkout');
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
        Schema::dropIfExists('booking');
    }
};
