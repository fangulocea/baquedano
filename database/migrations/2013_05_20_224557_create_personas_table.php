<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('personas');
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('direccion')->nullable();
            $table->string('numero')->nullable();
            $table->string('departamento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->integer('id_estado')->nullable();
            $table->integer('id_comuna')->nullable();
            $table->integer('id_region')->nullable();
            $table->integer('id_provincia')->nullable();
             $table->string('tipo_cargo')->nullable();
            $table->integer('cargo_id')->unsigned()->nullable();;
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->softDeletes();
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
        Schema::dropIfExists('personas');
    }
}
