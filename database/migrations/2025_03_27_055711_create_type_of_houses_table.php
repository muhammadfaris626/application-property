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
        Schema::create('type_of_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas')->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->unsignedBigInteger('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_of_houses');
    }
};
