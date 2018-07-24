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
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('id_cheque')->nullable();
            $table->string('detalle')->nullable();
            $table->string('E_S');
            $table->string('moneda');
            $table->double('valor_moneda', 20, 8)->nullable();
            $table->date('fecha_moneda');
            $table->double('valor_original_moneda', 20, 8);
            $table->double('valor_pagado_moneda', 20, 8);
            $table->double('saldo_moneda', 20, 8);
            $table->double('saldo_actual_moneda', 20, 8);
            $table->integer('valor_original');
            $table->integer('valor_pagado');
            $table->integer('saldo');
            $table->integer('saldo_actual');
            $table->string('tipo');
            $table->string('nombre');
            $table->string('ruta');
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
