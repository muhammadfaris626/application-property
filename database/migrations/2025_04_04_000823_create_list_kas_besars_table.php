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
        Schema::create('list_kas_besars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kas_besar_id')->constrained('kas_besars')->cascadeOnDelete();
            $table->foreignId('type_of_income_id')->nullable()->constrained('type_of_incomes')->cascadeOnDelete();
            $table->foreignId('type_of_expenditure_id')->nullable()->constrained('type_of_expenditures')->cascadeOnDelete();
            $table->text('desc');
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_kas_besars');
    }
};
