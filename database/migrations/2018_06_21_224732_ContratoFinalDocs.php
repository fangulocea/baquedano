<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContratoFinalDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('adm_contratofinaldocs');
            Schema::create('adm_contratofinaldocs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_final')->unsigned()->nullable();
            $table->foreign('id_final')->references('id')->on('adm_contratofinal');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->string('tipo');
            $table->string('nombre');
            $table->string('ruta');
            $table->string('id_creador')->nullable();
            $table->timestamps();
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
       Schema::dropIfExists('adm_contratofinaldocs');
    }
}
