<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_insentif', function (Blueprint $table) {
            $table->id();
            $table->string('npp_insentif')->unique();
            $table->string('nama_pegawai')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('level_insentif')->nullable();
            $table->string('penempatan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unit')->nullable();
            $table->double('nominal_max_insentif_kinerja')->default(0)->nullable();
            $table->float('kinerja_keuangan_perusahaan')->default(0)->nullable();
            $table->float('nilai_kpi')->default(0)->nullable();
            $table->double('insentif_kinerja')->default(0)->nullable();
            $table->double('pembulatan')->default(0)->nullable();
            $table->double('diterimakan')->default(0)->nullable();
            $table->string('insentif_periode_bulan');
            $table->string('insentif_pembayaran_bulan');
            $table->string('insentif_tahun');
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
        Schema::dropIfExists('payroll_insentif');
    }
};
