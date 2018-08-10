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
            $table->double('subtotal_entrada',20,2)->nullable();;
            $table->double('subtotal_salida',20,2)->nullable();;
            $table->double('pago_propietario',20,2)->nullable();;
            $table->double('pago_rentas',20,2)->nullable();;
            $table->double('valor_a_pagar',20,2)->nullable();;
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
