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
        Schema::create('office_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 100)->nullable();
            $table->string('no_registrasi', 100)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('merk', 100)->nullable();
            $table->string('tipe', 200)->nullable();
            $table->string('spek', 200)->nullable();
            $table->string('tahun_perolehan', 4)->nullable();
            $table->foreignId('ruangan_id')->constrained('office_ruangans');
            $table->foreignId('jenis_id')->constrained('office_jenis');
            $table->string('kode_lokasi', 4)->nullable();
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
        Schema::dropIfExists('office_inventories');
    }
};
