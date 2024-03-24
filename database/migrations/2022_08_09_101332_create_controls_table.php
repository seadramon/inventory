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
        Schema::create('office_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('office_inventories');
            $table->string('kelengkapan', 50)->nullable();
            $table->string('kondisi', 50)->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->string('created_by', 50)->nullable();
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
        Schema::dropIfExists('office_controls');
    }
};
