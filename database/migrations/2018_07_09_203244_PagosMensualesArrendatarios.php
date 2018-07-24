<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagosMensualesArrendatarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_pagosmensualesarrendatarios');
        Schema::create('adm_pagosmensualesarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contratofinal')->unsigned();
            $table->foreign('id_contratofinal')->references('id')->on('adm_contratofinalarr');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->integer('id_inmueble')->unsigned();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->date('fecha_iniciocontrato');
            $table->integer('mes');
            $table->integer('anio');
            $table->string('moneda');
            $table->date('fecha_moneda');
            $table->double('valormoneda', 20, 8);
            $table->double('subtotal_entrada', 20, 8)->nullable();;
            $table->double('subtotal_salida', 20, 8)->nullable();;
            $table->double('pago_a_arrendatario', 20, 8)->nullable();;
            $table->double('pago_a_rentas', 20, 8)->nullable();;
            $table->double('valor_a_pagar', 20, 8)->nullable();;
            $table->integer('subtotal_entrada')->nullable();;
            $table->integer('subtotal_salida')->nullable();;
            $table->integer('pago_a_arrendatario')->nullable();;
            $table->integer('pago_a_rentas')->nullable();;
            $table->integer('valor_a_pagar')->nullable();;
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
        Schema::dropIfExists('adm_pagosmensualesarrendatarios');
    }
}
