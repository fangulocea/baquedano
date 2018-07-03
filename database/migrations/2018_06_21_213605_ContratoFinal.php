<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContratoFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('adm_contratofinal');
        Schema::create('adm_contratofinal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_notaria')->unsigned()->nullable();
            $table->foreign('id_notaria')->references('id')->on('notarias')->nullable();
            $table->integer('id_publicacion')->unsigned()->nullable();;
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->date('fecha_firma')->nullable();
            $table->text('observaciones')->nullable();
             $table->string('alias')->nullable();
            $table->integer('id_estado');
            $table->integer('meses_contrato')->nullable();
            $table->integer('id_creador')->unsigned();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas')->nullable();
            $table->integer('id_borrador')->unsigned();
            $table->foreign('id_borrador')->references('id')->on('borradores');
            $table->integer('id_borradorpdf')->unsigned();
            $table->foreign('id_borradorpdf')->references('id')->on('borradorespdf');
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
        Schema::dropIfExists('adm_contratofinal');
    }
}
