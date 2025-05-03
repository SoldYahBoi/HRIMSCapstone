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
        Schema::create('marriages', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('place_city_municipality_id')->nullable()->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('place_province_id')->nullable()->constrained('provinces')->onDelete('restrict');
            $table->foreignId('place_country_id')->nullable()->constrained('countries')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriages');
    }
};