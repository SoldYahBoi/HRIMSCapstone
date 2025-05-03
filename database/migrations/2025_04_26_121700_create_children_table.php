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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth');
            $table->string('place_of_birth_hospital')->nullable();
            $table->foreignId('place_of_birth_city_municipality_id')->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('place_of_birth_province_id')->constrained('provinces')->onDelete('restrict');
            $table->string('type_of_birth')->default('Single'); // Single, Twin, Triplet, etc.
            $table->string('birth_order')->nullable(); // First, Second, Third, etc.
            $table->boolean('is_multiple_birth')->default(false);
            $table->string('multiple_birth_type')->nullable(); // First, Second, Third, etc.
            $table->decimal('weight_at_birth', 6, 2)->nullable(); // in grams
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};