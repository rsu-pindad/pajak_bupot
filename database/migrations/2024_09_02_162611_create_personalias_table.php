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
        Schema::create('personalias', function (Blueprint $table) {
            $table->id();
            $table->string('npp');
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('status_ptkp')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('epin')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalias');
    }
};
