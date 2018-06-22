<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaptacionCorredor extends Migration
{
     public function up()
    {
          Schema::dropIfExists('cap_corredores');
          Schema::create('cap_corredores', function (Blueprint $table) {
            $table->increments('id');
            $table->text('informacion_publicacion')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->date('fecha_expiracion')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('id_corredor')->unsigned()->nullable();
            $table->foreign('id_corredor')->references('id')->on('personas');
            $table->integer('id_propietario')->unsigned()->nullable();
            $table->foreign('id_propietario')->references('id')->on('personas');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');     
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');   
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas');        
            $table->integer('id_estado');
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
       Schema::dropIfExists('cap_corredores');
    }
}
