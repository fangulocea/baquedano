<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetallePagosPropietarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_detallepagospropietarios');
        Schema::create('adm_detallepagospropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pagomensual')->unsigned();
            $table->foreign('id_pagomensual')->references('id')->on('adm_pagosmensualespropietarios');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->string('E_S');
            $table->integer('valor_original');
            $table->integer('valor_pagado');
            $table->integer('saldo');
            $table->integer('id_creador');
            $table->integer('id_modificador');
            $table->integer('id_estado');
            $table->date('fecha_pago');
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
        Schema::dropIfExists('adm_detallepagospropietarios');
    }
}
