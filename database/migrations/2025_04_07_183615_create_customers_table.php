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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor_berkas');
            $table->foreignId('prospective_customer_id')->constrained('prospective_customers')->cascadeOnDelete();
            $table->foreignId('type_of_house_id')->constrained('type_of_houses')->cascadeOnDelete();
            $table->string('keterangan_rumah');
            $table->string('status_penjualan');
            $table->string('status_pengajuan_user');
            $table->integer('verifikasi_dp')->nullable();
            $table->string('upload_berkas');
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
