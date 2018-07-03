<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContratoInmueblesPropietarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('adm_contratodirpropietarios');
            Schema::create('adm_contratodirpropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contratofinal')->unsigned()->nullable();
            $table->foreign('id_contratofinal')->references('id')->on('adm_contratofinal');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
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
        Schema::dropIfExists('adm_contratodirpropietarios');
    }
}
