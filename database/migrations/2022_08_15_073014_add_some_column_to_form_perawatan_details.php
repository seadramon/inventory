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
        Schema::table('form_perawatan_details', function (Blueprint $table) {
            $table->string('pilihan', 100)->nullable();
            $table->string('foto_needed', 1)->default('0');
            $table->string('keterangan_needed', 1)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_perawatan_details', function (Blueprint $table) {
            $table->dropColumn(['pilihan', 'foto_needed', 'keterangan_needed']);
        });
    }
};
