<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmueblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('inmuebles');
        Schema::create('inmuebles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direccion');
            $table->string('condicion')->nullable();
            $table->integer('numero')->nullable();
            $table->string('departamento')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('dormitorio')->nullable();
            $table->string('rol')->nullable();
            $table->integer('bano')->nullable();
            $table->integer('estacionamiento')->nullable();
            $table->string('referencia')->nullable();
            $table->integer('bodega')->nullable();
             $table->string('nro_bodega')->nullable();
            $table->string('piscina')->nullable();
            $table->integer('precio')->nullable();
            $table->integer('gastosComunes')->nullable();
            $table->integer('id_comuna');
            $table->integer('id_region');
            $table->integer('id_provincia');
            $table->timestamps();
            $table->integer('estado');
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
        Schema::dropIfExists('inmuebles');
    }
}
