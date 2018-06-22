<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FotoRevisionPersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_fotorevpersona');
              Schema::create('adm_fotorevpersona', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_persona')->unsigned();
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('adm_fotorevpersona');
    }
}
