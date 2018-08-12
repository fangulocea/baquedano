<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioCuadraturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatario_cuadratura');
        Schema::create('arrendatario_cuadratura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinalarr');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->string('descripcion')->nullable();
            $table->integer('valor')->nullable();
            $table->string('id_estado')->nullable();
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
        Schema::dropIfExists('arrendatario_cuadratura');
    }
}
