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
        Schema::create('presensis', function (Blueprint $table) {
        $table->id('id_presensi');

        // Relasi ID
        $table->unsignedBigInteger('id_siswa')->nullable();
        $table->unsignedBigInteger('id_kelas')->nullable();
        $table->unsignedBigInteger('id_user')->nullable(); // guru

        // Backup nama (biar tetap ada kalau id sumber dihapus)
        $table->string('nama_siswa');
        $table->string('nama_guru')->nullable();
        $table->string('nama_kelas')->nullable();

        $table->date('tanggal');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa'])->default('hadir');
        $table->timestamps();

        // Foreign keys (pakai nullOnDelete, biar nggak bikin baris presensi terhapus)
        $table->foreign('id_siswa')->references('id_siswa')->on('data_siswas')->nullOnDelete();
        $table->foreign('id_kelas')->references('id_kelas')->on('data_kelas')->nullOnDelete();
        $table->foreign('id_user')->references('id')->on('users')->nullOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
