<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterHealingPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_healing_plan', function (Blueprint $table) {
            $table->id('id_healing');
            $table->string('judul_aktivitas'); 
            $table->text('deskripsi_detail'); 
            $table->string('kategori'); 
            $table->integer('poin_baterai'); 
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
        Schema::dropIfExists('master_healing_plan');
    }
}
