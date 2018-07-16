<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrReservasGes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arr_reservas_ges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('monto_reserva');
            $table->longText('descripcion')->nullable();
            $table->String('E_S')->nullable();        
            $table->integer('id_estado');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');  
            $table->integer('id_arr_ges')->unsigned()->nullable();
            $table->foreign('id_arr_ges')->references('id')->on('arrendatarios');
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
        Schema::dropIfExists('arr_reservas_ges');
    }
}
