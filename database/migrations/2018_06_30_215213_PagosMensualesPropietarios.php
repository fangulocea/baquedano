<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagosMensualesPropietarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('adm_pagosmensualespropietarios');
        Schema::create('adm_pagosmensualespropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contratofinal')->unsigned();
            $table->foreign('id_contratofinal')->references('id')->on('adm_contratofinal');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->string('E_S');
            $table->date('fecha_iniciocontrato');
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('valor_a_pagar');
            $table->integer('id_creador');
            $table->integer('id_modificador');
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
        Schema::dropIfExists('adm_pagosmensualespropietarios');
    }
}
