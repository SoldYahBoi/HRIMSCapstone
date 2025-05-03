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
        Schema::create('birth_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('registry_no')->unique();
            $table->foreignId('province_id')->constrained()->onDelete('restrict');
            $table->foreignId('city_municipality_id')->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('child_id')->constrained()->onDelete('restrict');
            $table->foreignId('mother_id')->constrained()->onDelete('restrict');
            $table->foreignId('father_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('marriage_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('birth_attendant_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('informant_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('prepared_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->foreignId('received_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->foreignId('registered_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->text('remarks')->nullable();
            $table->string('contact_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_certificates');
    }
};