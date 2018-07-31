<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdmCargosabonosarrendatarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_cargosabonosarrendatarios');
        Schema::create('adm_cargosabonosarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pagomensual')->unsigned();
            $table->foreign('id_pagomensual')->references('id')->on('adm_pagosmensualesarrendatarios');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('tipooperacion')->nullable();
            $table->string('nombreoperacion')->nullable();
            $table->date('fecha_multa')->nullable();
            $table->date('fecha_reajuste')->nullable();
            $table->string('moneda');
            $table->date('fecha_moneda');
            $table->double('valor_moneda', 20, 8);
            $table->double('monto_moneda', 20, 8);
            $table->integer('monto_pesos');
            $table->string('tipo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->integer('id_creador');
            $table->integer('id_modificador');
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
        Schema::dropIfExists('adm_cargosabonosarrendatarios');
    }
}
