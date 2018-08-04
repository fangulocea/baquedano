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
            $table->date('fecha_moneda');
            $table->date('valor_moneda');
            $table->date('valor_pesos');
            $table->string('nombre_servicio');
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
