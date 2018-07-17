<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrReservasdocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arr_reservasdocs');
        Schema::create('arr_reservasdocs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_reserva')->unsigned();
            $table->foreign('id_reserva')->references('id')->on('arr_reservas');
            $table->integer('id_arrendatario')->unsigned();
            $table->foreign('id_arrendatario')->references('id')->on('arrendatarios');
            $table->string('descripcion')->nullable();
            $table->string('nombre');
            $table->string('ruta');
            $table->string('id_creador')->nullable();
            $table->integer('id_estado');
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
        Schema::dropIfExists('arr_reservasdocs');
    }
}
