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
        Schema::table('data_siswas', function (Blueprint $table) {
            // Tambah kolom status siswa
            $table->enum('status', ['aktif', 'lulus', 'tidak_naik_kelas', 'pindah', 'keluar'])
                  ->default('aktif')
                  ->after('no_tlp');
            
            // Tambah tahun masuk & tahun lulus
            $table->year('tahun_masuk')->nullable()->after('status');
            $table->year('tahun_lulus')->nullable()->after('tahun_masuk');
            
            // Index untuk performa
            $table->index('status');
            $table->index('tahun_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_siswas', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tahun_masuk']);
            $table->dropColumn(['status', 'tahun_masuk', 'tahun_lulus']);
        });
    }
};