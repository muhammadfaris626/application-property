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
        Schema::create('pengajuan_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->unsignedBigInteger('price');
            $table->text('desc');
            $table->unsignedBigInteger('approved_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_invoices');
    }
};
