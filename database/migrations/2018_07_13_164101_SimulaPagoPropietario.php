<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimulaPagoPropietario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cap_simulapagopropietarios');
        Schema::create('cap_simulapagopropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_simulacion')->nullable();
            $table->integer('id_publicacion')->nullable();
            $table->integer('id_inmueble')->nullable();
            $table->integer('id_propietario')->nullable();
            $table->integer('tipo');
            $table->string('tipopago');
            $table->string('idtipopago');
            $table->integer('meses_contrato');
            $table->date('fecha_iniciocontrato');
            $table->integer('dia');
            $table->double('descuento', 20, 8);
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('cant_diasmes');
            $table->integer('cant_diasproporcional');
            $table->string('moneda');
            $table->double('valormoneda', 20, 8);
            $table->double('valordia', 20, 8);
            $table->double('precio_en_moneda', 20, 8);
            $table->double('precio_en_pesos',20,2);
            $table->integer('id_creador');
            $table->integer('id_modificador');
            $table->integer('id_estado');
            $table->double('canondearriendo', 20, 8);
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
