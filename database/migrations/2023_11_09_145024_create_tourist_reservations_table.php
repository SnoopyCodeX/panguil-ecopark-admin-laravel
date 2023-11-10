<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tourist_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('reservation_id');
            $table->integer('number_of_adults');
            $table->integer('number_of_children');
            $table->string('reserve_date');
            $table->string('arrival_time');
            $table->string('phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_reservations');
    }
};
