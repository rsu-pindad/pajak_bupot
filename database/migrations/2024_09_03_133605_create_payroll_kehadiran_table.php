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
        Schema::create('payroll_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('npp_kehadiran')->unique();
            $table->string('nama_pegawai')->nullable();
            $table->double('tunjangan_kehadiran')->default(0)->nullable();
            $table->integer('jumlah_hari_kerja')->default(0)->nullable();
            $table->integer('jumlah_jam_terbuang')->default(0)->nullable();
            $table->integer('jumlah_cuti')->default(0)->nullable();
            $table->double('potongan_absensi')->default(0)->nullable();
            $table->double('jumlah_pendapatan')->default(0)->nullable();
            $table->double('jumlah_pembulatan')->default(0)->nullable();
            $table->double('jumlah_diterimakan')->default(0)->nullable();
            $table->string('kehadiran_bulan');
            $table->string('kehadiran_tahun');
            $table->boolean('has_blast')->default(false)->nullable();
            $table->boolean('status_blast')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_kehadiran');
    }
};
