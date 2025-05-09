<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('death_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('registry_no')->unique();
            $table->foreignId('province_id')->constrained()->onDelete('restrict');
            $table->foreignId('city_municipality_id')->constrained('cities_municipalities')->onDelete('restrict');
            $table->foreignId('deceased_id')->constrained()->onDelete('restrict');
            $table->foreignId('death_cause_id')->constrained()->onDelete('restrict');
            $table->foreignId('death_attendant_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('death_informant_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('corpse_disposal_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('prepared_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->foreignId('received_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->foreignId('registered_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->foreignId('reviewed_by_id')->nullable()->constrained('officials')->onDelete('restrict');
            $table->text('remarks')->nullable();
            $table->string('contact_no')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('death_certificates');
    }
};