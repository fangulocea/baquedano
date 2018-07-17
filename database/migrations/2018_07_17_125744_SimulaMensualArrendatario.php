<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimulaMensualArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cap_simulamensualarrendatarios');
        Schema::create('cap_simulamensualarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_simulacion')->nullable();
            $table->integer('id_publicacion')->nullable();
            $table->integer('id_inmueble')->nullable();
           $table->integer('id_arrendatario')->nullable();
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
        //
    }
}
