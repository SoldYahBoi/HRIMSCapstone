<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deceaseds', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death');
            $table->integer('age_years')->nullable();
            $table->integer('age_months')->nullable();
            $table->integer('age_days')->nullable();
            $table->integer('age_hours')->nullable();
            $table->integer('age_minutes')->nullable();
            $table->string('place_of_death')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('residence_house_no')->nullable();
            $table->string('residence_street')->nullable();
            $table->string('residence_barangay')->nullable();
            $table->foreignId('residence_city_municipality_id')->nullable()->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('residence_province_id')->nullable()->constrained('provinces')->onDelete('restrict');
            $table->foreignId('residence_country_id')->nullable()->constrained('countries')->onDelete('restrict');
            $table->string('occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_maiden_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deceaseds');
    }
};