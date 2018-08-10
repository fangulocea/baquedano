<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleCuentasPropietario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('post_detallecuentasPRO');
        Schema::create('post_detallecuentasPRO', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cuenta');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_propietario');
            $table->integer('id_creador');
            $table->integer('id_serviciobasico');
            $table->integer('mes');
            $table->integer('anio');
            $table->date('fecha_vencimiento');
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->date('fecha_uf');
            $table->double('valor_uf',20,8);
            $table->double('valor_en_uf',20,8);
            $table->double('valor_en_pesos',20,2);
            $table->integer('cantidad');
            $table->double('subtotal_uf',20,8);
            $table->double('subtotal_pesos',20,2);
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
        Schema::dropIfExists('post_detallecuentasPRO');
    }
}
