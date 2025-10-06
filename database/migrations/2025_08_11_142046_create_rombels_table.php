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
        Schema::create('rombels', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_siswa');  // ← Ubah jadi unsignedBigInteger
        $table->unsignedBigInteger('id_kelas');  // ← Ubah jadi unsignedBigInteger
        $table->unsignedBigInteger('id_jurusan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
