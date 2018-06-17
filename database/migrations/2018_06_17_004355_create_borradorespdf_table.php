<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorradorespdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('borradorespdf');
        Schema::create('borradorespdf', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_borrador')->unsigned();
            $table->foreign('id_borrador')->references('id')->on('borradores');
            $table->string('nombre');
            $table->string('ruta');
            $table->string('id_creador')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('borradorespdf');
    }
}
