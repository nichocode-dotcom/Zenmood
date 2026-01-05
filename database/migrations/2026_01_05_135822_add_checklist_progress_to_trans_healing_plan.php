<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trans_healing_plan', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('is_completed');
            $table->json('checklist')->nullable()->after('progress');
            $table->timestamp('started_at')->nullable()->after('tanggal');
            $table->timestamp('completed_at')->nullable()->after('started_at');
        });
    }

    public function down()
    {
        Schema::table('trans_healing_plan', function (Blueprint $table) {
            $table->dropColumn(['progress', 'checklist', 'started_at', 'completed_at']);
        });
    }
};