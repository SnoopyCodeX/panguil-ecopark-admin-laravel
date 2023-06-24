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
        Schema::create('tourists_to_guide', function (Blueprint $table) {
            $table->id();
            $table->string('tour_guide_name');
            $table->datetime('assigned_datetime');
            $table->string('tourist_name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);
            $table->string('contact_number', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourists_to_guides');
    }
};
