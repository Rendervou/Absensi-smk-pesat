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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('id_alumni');
            $table->unsignedBigInteger('id_siswa');
            $table->string('nama_siswa');
            $table->string('nis')->unique();
            $table->string('no_tlp')->nullable();
            $table->unsignedBigInteger('id_kelas_terakhir');
            $table->string('nama_kelas_terakhir');
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->string('nama_jurusan')->nullable();
            $table->year('tahun_lulus');
            $table->date('tanggal_kelulusan');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_siswa')->references('id_siswa')->on('data_siswas')->onDelete('cascade');
            $table->foreign('id_kelas_terakhir')->references('id_kelas')->on('data_kelas')->onDelete('cascade');
            
            // Index untuk performa query
            $table->index('tahun_lulus');
            $table->index('nama_kelas_terakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};