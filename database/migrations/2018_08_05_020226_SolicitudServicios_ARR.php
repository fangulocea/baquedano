<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudServiciosARR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                Schema::dropIfExists('post_solicitudserviciosARR');
        Schema::create('post_solicitudserviciosARR', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_arrendatario');
            $table->integer('id_creador');
            $table->integer('id_modificador')->nullable();
            $table->integer('id_autorizador')->nullable();
            $table->integer('id_asignacion')->nullable();
            $table->date('fecha_autorizacion')->nullable();
            $table->date('fecha_uf');
            $table->double('valor_uf',20,8);
            $table->double('valor_en_uf',20,8);
            $table->double('valor_en_pesos',20,2);
            $table->integer('id_estado')->nullable();
            $table->string('detalle')->nullable();
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
        Schema::dropIfExists('post_solicitudserviciosARR');
    }
}
