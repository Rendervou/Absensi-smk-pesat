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
        // Cek apakah tabel sudah ada
        if (!Schema::hasTable('alumni')) {
            Schema::create('alumni', function (Blueprint $table) {
                $table->id('id_alumni');
                $table->unsignedBigInteger('id_siswa');
                $table->string('nama_siswa');
                $table->string('nis');
                $table->string('no_tlp')->nullable();
                $table->unsignedBigInteger('id_kelas_terakhir')->nullable();
                $table->string('nama_kelas_terakhir');
                $table->unsignedBigInteger('id_jurusan')->nullable();
                $table->string('nama_jurusan')->nullable();
                $table->year('tahun_lulus');
                $table->date('tanggal_kelulusan');
                $table->text('catatan')->nullable();
                $table->timestamps();

                // Index untuk performa query
                $table->index('tahun_lulus');
                $table->index('nama_kelas_terakhir');
                $table->index('nis');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};