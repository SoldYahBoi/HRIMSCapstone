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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('location');
            $table->string('employment_type');
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->string('salary_range')->nullable();
            $table->date('application_deadline');
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};