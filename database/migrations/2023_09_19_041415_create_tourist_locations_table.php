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
        Schema::create('tourist_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('latitude');
            $table->double('longitude');
            $table->enum('status', ['entered', 'exited']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_locations');
    }
};
