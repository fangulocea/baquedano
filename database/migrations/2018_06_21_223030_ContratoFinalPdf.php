<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContratoFinalPdf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('adm_contratofinalpdf');
            Schema::create('adm_contratofinalpdf', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_final')->unsigned();
            $table->foreign('id_final')->references('id')->on('adm_contratofinal');
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
         Schema::dropIfExists('adm_contratofinalpdf');
    }
}
