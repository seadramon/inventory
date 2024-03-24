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
        Schema::table('software', function (Blueprint $table) {
            $table->string('jenis_lisensi', 50)->nullable();
            $table->string('tipe_langganan', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('serial_key', 150)->nullable();
            $table->date('expired')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('software', function (Blueprint $table) {
            $table->dropColumn(['jenis_lisensi', 'tipe_langganan', 'email', 'serial_key', 'expired']);
        });
    }
};
