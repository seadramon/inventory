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
        Schema::table('inv_pc_h', function (Blueprint $table) {
            $table->string('tipe_pengguna', 30)->nullable();
            $table->integer('no_registrasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_pc_h', function (Blueprint $table) {
            $table->dropColumn(['tipe_pengguna', 'no_registrasi']);
        });
    }
};
