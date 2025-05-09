<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('death_attendants', function (Blueprint $table) {
            $table->id();
            $table->integer('attendant_type')->comment('1=Private Physician, 2=Public Health Officer, 3=Hospital Authority, 4=None, 5=Others');
            $table->string('other_attendant_type')->nullable();
            $table->string('name')->nullable();
            $table->string('title_or_position')->nullable();
            $table->string('address')->nullable();
            $table->date('attended_from')->nullable();
            $table->date('attended_to')->nullable();
            $table->boolean('attended_deceased')->default(false);
            $table->string('death_time')->nullable();
            $table->date('certification_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('death_attendants');
    }
};