<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_kelas_terakhir']);
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->foreign('id_siswa')->references('id_siswa')->on('data_siswas')->onDelete('cascade');
            $table->foreign('id_kelas_terakhir')->references('id_kelas')->on('data_kelas')->onDelete('cascade');
        });
    }
};