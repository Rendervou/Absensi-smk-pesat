<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_siswas', function (Blueprint $table) {
            // Hapus "after('alamat')" karena kolom itu ga ada
            $table->unsignedBigInteger('id_kelas')->nullable();

            $table->foreign('id_kelas')
                ->references('id_kelas')
                ->on('data_kelas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('data_siswas', function (Blueprint $table) {
            $table->dropForeign(['id_kelas']);
            $table->dropColumn('id_kelas');
        });
    }


};
