<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropietariopagofindocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('propietariopagofindoc');
        Schema::create('propietariopagofindoc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pago')->unsigned()->nullable();
            $table->foreign('id_pago')->references('id')->on('propietariopagofin');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinal');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->string('tipo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->string('id_creador')->nullable();
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
        Schema::dropIfExists('propietariopagofindoc');
    }
}
