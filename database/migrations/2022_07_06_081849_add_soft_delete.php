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
        Schema::table('tb_merk', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tb_tipe_pc', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tb_item', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('inv_pc_h', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('inv_pc_d', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_merk', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('tb_tipe_pc', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('tb_item', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('inv_pc_h', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('inv_pc_d', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
    }
};
