<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleSolicitudServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('post_detallesolservicios');
        Schema::create('post_detallesolservicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_propietario');
            $table->integer('id_creador');
            $table->integer('id_servicio');
            $table->date('fecha_uf');
            $table->double('valor_uf',20,8);
            $table->double('valor_en_uf',20,8);
            $table->integer('valor_en_pesos');
            $table->integer('cantidad');
            $table->double('subtotal_uf',20,8);
            $table->integer('subtotal_pesos');
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
        //
    }
}