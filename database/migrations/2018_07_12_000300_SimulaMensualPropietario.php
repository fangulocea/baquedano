<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimulaMensualPropietario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('cap_simulamensualpropietarios');
        Schema::create('cap_simulamensualpropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_simulacion')->unsigned();
            $table->foreign('id_simulacion')->references('id')->on('cap_simulapropietario');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
           $table->integer('id_propietario')->unsigned();
            $table->foreign('id_propietario')->references('id')->on('personas');
            $table->date('fecha_iniciocontrato');
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('subtotal_entrada')->nullable();;
            $table->integer('subtotal_salida')->nullable();;
            $table->integer('pago_propietario')->nullable();;
            $table->integer('pago_rentas')->nullable();;
            $table->integer('valor_a_pagar')->nullable();;
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
        Schema::dropIfExists('cap_simulapagopropietarios');
    }
}
