<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('death_causes', function (Blueprint $table) {
            $table->id();
            $table->string('immediate_cause')->nullable();
            $table->string('antecedent_cause')->nullable();
            $table->string('underlying_cause')->nullable();
            $table->text('other_significant_conditions')->nullable();
            $table->string('interval_between_onset_and_death')->nullable();
            $table->enum('maternal_condition', [
                'pregnant, not in labour',
                'pregnant, in labour',
                'less than 42 days after delivery',
                '42 days to 1 year after delivery',
                'None of the choices'
            ])->nullable();
            $table->string('manner_of_death')->nullable();
            $table->string('external_cause_place')->nullable();
            $table->boolean('autopsy_performed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('death_causes');
    }
};