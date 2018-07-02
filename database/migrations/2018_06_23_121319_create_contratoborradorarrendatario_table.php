<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoborradorarrendatarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contratoborradorarrendatarios');
        Schema::create('contratoborradorarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cap_arr');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles')->nullable();
            $table->integer('id_arrendatario')->unsigned()->nullable();
            $table->foreign('id_arrendatario')->references('id')->on('personas')->nullable();
            $table->integer('id_servicios')->unsigned()->nullable();
            $table->foreign('id_servicios')->references('id')->on('servicios')->nullable();
            $table->integer('id_formadepago')->unsigned()->nullable();
            $table->foreign('id_formadepago')->references('id')->on('formasdepagos')->nullable();
            $table->integer('id_comisiones')->unsigned();
            $table->foreign('id_comisiones')->references('id')->on('comisiones');
            $table->integer('id_flexibilidad')->unsigned();
            $table->foreign('id_flexibilidad')->references('id')->on('flexibilidads');
            $table->integer('id_multa')->unsigned();
            $table->foreign('id_multa')->references('id')->on('multas');
            $table->integer('dia_pago')->nullable();
            $table->date('fecha_contrato')->nullable();
            $table->text('detalle');
            $table->integer('valorarriendo');
            $table->integer('id_estado');
            $table->integer('id_creador')->unsigned();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas')->nullable();
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('contratos');
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
        Schema::dropIfExists('contratoborradorarrendatarios');
    }
}
