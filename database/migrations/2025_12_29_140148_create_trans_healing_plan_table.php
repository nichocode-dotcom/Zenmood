<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransHealingPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_healing_plan', function (Blueprint $table) {
            $table->id('id_trans_heal');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_healing')->constrained('master_healing_plan', 'id_healing');
            $table->date('tanggal');
            $table->boolean('is_utama')->default(false);
            $table->boolean('is_completed')->default(false); 
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
        Schema::dropIfExists('trans_healing_plan');
    }
}
