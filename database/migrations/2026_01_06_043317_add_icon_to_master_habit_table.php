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
    Schema::table('master_habit', function (Blueprint $table) {
        // Tambahkan kolom icon, default 'star' agar data lama tidak error
        $table->string('icon')->default('star')->after('target_harian'); 
    });
}

    public function down()
    {
        Schema::table('master_habit', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
    