<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corpse_disposals', function (Blueprint $table) {
            $table->id();
            $table->string('disposal_type')->comment('Burial, Cremation, Others');
            $table->string('other_disposal_type')->nullable();
            $table->string('burial_cremation_permit_number')->nullable();
            $table->date('burial_cremation_permit_date')->nullable();
            $table->string('transfer_permit_number')->nullable();
            $table->date('transfer_permit_date')->nullable();
            $table->string('cemetery_name')->nullable();
            $table->string('cemetery_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpse_disposals');
    }
};