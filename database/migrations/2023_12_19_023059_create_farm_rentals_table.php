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
        Schema::create('farm_rentals', function (Blueprint $table) {
          $table->id('rental_id');
          $table->string('location_block');
          $table->string('location_lot');
          $table->string('hectares');
          $table->decimal('rental_amount', 8, 2);
          $table->boolean('availability');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_rentals');
    }
};
