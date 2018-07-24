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
             $table->string('moneda');
            $table->double('valor_moneda', 20, 8)->nullable();
            $table->date('fecha_moneda');
            $table->date('fecha_iniciocontrato');
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('subtotal_entrada')->nullable();
            $table->double('subtotal_salida', 20, 8)->nullable();
            $table->double('subtotal_salida_moneda', 20, 8)->nullable();
            $table->double('pago_propietario', 20, 8)->nullable();
            $table->double('pago_propietario_moneda', 20, 8)->nullable();
            $table->integer('pago_rentas')->nullable();
            $table->double('valor_a_pagar', 20, 8)->nullable();
            $table->double('valor_a_pagar_moneda', 20, 8)->nullable();
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
