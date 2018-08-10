<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdmCargosabonospropietarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_cargosabonospropietarios');
        Schema::create('adm_cargosabonospropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pagomensual')->unsigned();
            $table->foreign('id_pagomensual')->references('id')->on('adm_pagosmensualespropietarios');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('tipooperacion')->nullable();
            $table->string('nombreoperacion')->nullable();
            $table->string('moneda');
            $table->date('fecha_moneda');
            $table->double('valor_moneda', 20, 8);
            $table->double('monto_moneda', 20, 8);
            $table->double('monto_pesos',20,2);
            $table->string('tipo');
            $table->string('nombre');
            $table->string('ruta');
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
        Schema::dropIfExists('adm_cargosabonospropietarios');
    }
}
