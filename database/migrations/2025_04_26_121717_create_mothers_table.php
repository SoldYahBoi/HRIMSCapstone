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
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('maiden_name');
            $table->string('citizenship');
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedTinyInteger('age_at_birth')->nullable();
            $table->string('residence_house_no')->nullable();
            $table->string('residence_street')->nullable();
            $table->string('residence_barangay')->nullable();
            $table->foreignId('residence_city_municipality_id')->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('residence_province_id')->constrained('provinces')->onDelete('restrict');
            $table->foreignId('residence_country_id')->constrained('countries')->onDelete('restrict');
            $table->unsignedTinyInteger('total_children_born_alive')->default(0);
            $table->unsignedTinyInteger('children_still_living')->default(0);
            $table->unsignedTinyInteger('children_born_alive_now_dead')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};