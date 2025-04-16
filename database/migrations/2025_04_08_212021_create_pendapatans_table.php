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
        Schema::create('pendapatans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('type_of_income_id')->constrained('type_of_incomes')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->text('keterangan');
            $table->bigInteger('total');
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatans');
    }
};
