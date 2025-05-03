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
        Schema::create('cities_municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->boolean('is_city')->default(false);
            $table->timestamps();
            
            $table->unique(['name', 'province_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities_municipalities');
    }
};