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
        Schema::create('form_perawatan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_perawatan_id')->constrained();
            $table->string('nama', 200);
            $table->string('parameter', 100);
            $table->string('jenis', 30);
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
        Schema::dropIfExists('form_perawatan_details');
    }
};
