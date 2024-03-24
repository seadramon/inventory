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
        Schema::create('inv_pc_software', function (Blueprint $table) {
            $table->id();
            $table->string('no_inventaris', 30);
            $table->foreignId('software_id')->constrained();
            $table->string('jenis_lisensi', 50)->nullable();
            $table->string('tipe_langganan', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('serial_key', 150)->nullable();
            $table->date('expired')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('INV_PC_SOFTWARE');
    }
};
