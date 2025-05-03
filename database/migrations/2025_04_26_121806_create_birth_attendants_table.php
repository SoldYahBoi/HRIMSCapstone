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
        Schema::create('birth_attendants', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('attendant_type'); // 1-Physician, 2-Nurse, 3-Midwife, 4-Hilot, 5-Others
            $table->string('other_attendant_type')->nullable(); // If attendant_type is 5-Others
            $table->string('signature')->nullable();
            $table->string('name');
            $table->string('title_or_position')->nullable();
            $table->text('address')->nullable();
            $table->date('certification_date')->nullable();
            $table->string('birth_time')->nullable(); // am/pm format
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_attendants');
    }
};