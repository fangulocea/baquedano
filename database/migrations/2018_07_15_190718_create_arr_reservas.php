<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrReservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arr_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_condicion')->unsigned()->nullable();
            $table->foreign('id_condicion')->references('id')->on('condicions');
            $table->integer('monto_reserva');
            $table->longText('descripcion')->nullable();
            $table->integer('id_arr_ges')->unsigned()->nullable();
            $table->foreign('id_arr_ges')->references('id')->on('arrendatarios');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');   
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas');        
            $table->integer('id_estado');
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
        Schema::dropIfExists('arr_reservas');
    }
}
