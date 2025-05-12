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
        Schema::create('recruitment_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('open_positions')->default(0);
            $table->integer('new_applications')->default(0);
            $table->integer('interviews_scheduled')->default(0);
            $table->integer('positions_filled')->default(0);
            $table->integer('total_applications')->default(0);
            $table->integer('avg_time_to_hire')->nullable();
            $table->decimal('acceptance_rate', 5, 2)->nullable();
            $table->decimal('cost_per_hire', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_stats');
    }
};