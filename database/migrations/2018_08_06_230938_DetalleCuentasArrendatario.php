<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleCuentasArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::dropIfExists('post_detallecuentasARR');
        Schema::create('post_detallecuentasARR', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_arrendatario');
            $table->integer('id_creador');
            $table->integer('id_serviciobasico');
            $table->integer('mes');
            $table->integer('anio');
            $table->date('fecha_vencimiento');
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->integer('valor_en_pesos');
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
        Schema::dropIfExists('post_detallecuentasARR');
    }
}
