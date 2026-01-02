<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterHabit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_habit', function (Blueprint $table) {
            $table->id('id_habit');
            // $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nama');
            $table->string('target_harian');
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
        Schema::dropIfExists('master_habit');
    }
}
