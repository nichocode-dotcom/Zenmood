<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mood', function (Blueprint $table) {
            $table->id('id_mood');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_emosi')->constrained('emosi', 'id_emosi');

            $table->foreignId('id_aktivitas')->constrained('master_aktivitas', 'id_aktivitas');
            
            $table->date('tanggal');
            $table->time('jam');
            $table->string('kategori_aktivitas'); 
            $table->string('faktor_sistem')->nullable(); 
            $table->integer('skor')->nullable();
            
            $table->text('faktor_note')->nullable(); 
            $table->text('hal_disyukuri')->nullable(); 
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
        Schema::dropIfExists('mood');
    }
}
