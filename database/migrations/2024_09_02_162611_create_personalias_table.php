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
            $table->string('nik');
            $table->string('npwp');
            $table->string('status_ptkp');
            $table->string('email');
            $table->string('no_hp');
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
