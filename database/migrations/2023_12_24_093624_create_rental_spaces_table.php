<?php

use App\Models\Employees;
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
        Schema::create('rental_spaces', function (Blueprint $table) {
            $table->id('rental_space_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('location');
            $table->string('monthly_price');
            $table->dateTime('date_created');
            $table->timestamps();
        });

        Schema::table('rental_spaces', function (Blueprint $table) {
            $table->foreignIdFor(Employees::class, 'employee_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_spaces');
    }
};
