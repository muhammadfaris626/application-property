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
        Schema::create('kartu_kontrols', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->integer('sbum')->nullable();
            $table->integer('dp')->nullable();
            $table->integer('imb')->nullable();
            $table->integer('sertifikat')->nullable();
            $table->integer('jkk')->nullable();
            $table->integer('listrik')->nullable();
            $table->integer('bestek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_kontrols');
    }
};
