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
        Schema::create('available_reservations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['kubo', 'cottage']);
            $table->decimal('price_per_head');
            $table->decimal('children_discount');
            $table->string('name_of_spot');
            $table->string('size_of_spot');
            $table->string('description');
            $table->string('photo')->nullable();
            $table->enum('status', ['available', 'out_of_service'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_reservations');
    }
};
