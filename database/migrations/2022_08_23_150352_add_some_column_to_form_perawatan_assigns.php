<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_perawatan_assigns', function (Blueprint $table) {
            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();
        });
        Schema::table('perawatans', function (Blueprint $table) {
            $table->foreignId('assign_id')->nullable()->constrained('form_perawatan_assigns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_perawatan_assigns', function (Blueprint $table) {
            $table->dropColumn(['periode_awal', 'periode_akhir']);
        });
        Schema::table('perawatans', function (Blueprint $table) {
            $table->dropColumn(['assign_id']);
        });
    }
};
