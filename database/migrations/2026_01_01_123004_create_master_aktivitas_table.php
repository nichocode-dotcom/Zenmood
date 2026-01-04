<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_aktivitas', function (Blueprint $table) {

            $table->id('id_aktivitas');
            $table->string('nama_aktivitas');
            $table->integer('id_kategori'); // Fisik=1, Kerja=2, dll
            $table->string('label'); // Fisik, Kerja, dll
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_aktivitas');
    }
}
