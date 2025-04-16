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
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_flow_id')->constrained('approval_flows')->cascadeOnDelete();
            $table->bigInteger('approvable_id');
            $table->string('approvable_type');
            $table->foreignId('approval_step_id')->constrained('approval_steps')->cascadeOnDelete();
            $table->text('desc')->nullable();
            $table->string('marker')->default('menunggu persetujuan');
            $table->foreignId('approved_by')->constrained('employees')->cascadeOnDelete();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};
