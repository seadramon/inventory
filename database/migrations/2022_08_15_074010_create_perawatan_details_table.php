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
        Schema::create('perawatan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perawatan_id')->constrained();
            $table->string('nama', 100);
            $table->string('value', 100)->nullable();
            $table->string('foto', 200)->nullable();
            $table->string('keterangan', 200)->nullable();
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
        Schema::dropIfExists('perawatan_details');
    }
};
