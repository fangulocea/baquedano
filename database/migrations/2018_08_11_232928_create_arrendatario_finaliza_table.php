<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioFinalizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatario_finaliza');
        Schema::create('arrendatario_finaliza', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinalarr');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->string('descripcion')->nullable();
            $table->string('nombre');
            $table->string('ruta');
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
        Schema::dropIfExists('arrendatario_finaliza');
    }
}
