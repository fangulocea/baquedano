<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatariopagofindocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatariopagofindoc');
        Schema::create('arrendatariopagofindoc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pago')->unsigned()->nullable();
            $table->foreign('id_pago')->references('id')->on('arrendatariopagofin');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinalarr');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
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
        Schema::dropIfExists('arrendatariopagofindoc');
    }
}
