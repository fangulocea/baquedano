<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('borradores');
        Schema::create('borradores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_notaria')->unsigned()->nullable();
            $table->foreign('id_notaria')->references('id')->on('notarias')->nullable();
            $table->integer('id_servicios')->unsigned()->nullable();
            $table->foreign('id_servicios')->references('id')->on('servicios')->nullable();
            $table->integer('id_comisiones')->unsigned()->nullable();
            $table->foreign('id_comisiones')->references('id')->on('comisiones')->nullable();
            $table->integer('id_flexibilidad')->unsigned()->nullable();
            $table->foreign('id_flexibilidad')->references('id')->on('flexibilidads');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_formadepago')->unsigned()->nullable();
            $table->foreign('id_formadepago')->references('id')->on('formasdepagos')->nullable();
            $table->integer('id_multa')->unsigned()->nullable();
            $table->foreign('id_multa')->references('id')->on('multas')->nullable();
            $table->integer('dia_pago')->nullable();
            $table->integer('valorarriendo')->nullable();
            $table->date('fecha_gestion')->nullable();
            $table->text('detalle_revision');
            $table->integer('id_estado');
            $table->integer('id_creador')->unsigned();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas')->nullable();
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('contratos');
            $table->integer('id_simulacion')->unsigned();
            $table->foreign('id_simulacion')->references('id')->on('cap_simulapropietario');
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
        Schema::dropIfExists('borradores');
    }
}
