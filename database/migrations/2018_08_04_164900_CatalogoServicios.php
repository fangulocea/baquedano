<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogoServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('post_catalogoservicios');
        Schema::create('post_catalogoservicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_creador');
            $table->integer('id_modificador');
            $table->string('moneda');
            $table->string('detalle');
            $table->date('fecha_moneda');
            $table->double('valor_moneda',20,8);
            $table->double('valor_en_pesos',20,2);
            $table->double('valor_en_moneda',20,8);
            $table->string('nombre_servicio');
            $table->string('unidad_medida');
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
        Schema::dropIfExists('post_catalogoservicios');
    }
}
