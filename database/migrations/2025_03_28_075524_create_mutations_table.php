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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('from_area_id')->constrained('areas')->cascadeOnDelete();
            $table->foreignId('to_area_id')->constrained('areas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
