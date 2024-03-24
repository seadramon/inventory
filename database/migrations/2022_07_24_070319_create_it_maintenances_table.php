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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('no_inventaris', 30);
            $table->string('no_tiket', 30);
            $table->string('permasalahan', 300);
            $table->string('diagnosa', 300);
            $table->string('tindak_lanjut', 300);
            $table->string('jenis_penanganan', 30);
            $table->string('hasil', 300);
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
        Schema::dropIfExists('maintenances');
    }
};
