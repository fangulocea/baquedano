<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagosArrendatarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_pagosarrendatarios');
        Schema::create('adm_pagosarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contratofinal')->unsigned();
            $table->foreign('id_contratofinal')->references('id')->on('adm_contratofinalarr');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->integer('id_inmueble')->unsigned();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->string('tipopago');
            $table->string('E_S');
            $table->string('idtipopago');
             $table->string('tipopropuesta');
            $table->integer('meses_contrato');
            $table->date('fecha_iniciocontrato');
            $table->integer('dia');
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('cant_diasmes');
            $table->integer('cant_diasproporcional');
            $table->string('moneda');
            $table->double('valormoneda', 20, 8);
            $table->double('valordia', 20, 8);
            $table->double('precio_en_moneda', 20, 8);
            $table->integer('precio_en_pesos');
            $table->integer('id_creador');
            $table->integer('id_modificador');
            $table->integer('id_estado');
            $table->double('canondearriendo', 20, 8);
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
       Schema::dropIfExists('adm_pagosarrendatarios');
    }
}
