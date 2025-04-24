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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birthdate');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->string('contact_number')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->date('hire_date');
            $table->enum('status', ['Active', 'Resigned', 'Terminated'])->default('Active');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('employment_type_id')->nullable(); // optional

            $table->timestamps();

            // Foreign keys (assuming these tables exist)
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employment_type_id')->references('id')->on('employments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
