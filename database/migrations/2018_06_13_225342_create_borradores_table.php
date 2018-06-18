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
            $table->integer('id_comisiones')->unsigned();
            $table->foreign('id_comisiones')->references('id')->on('comisiones');
            $table->integer('id_flexibilidad')->unsigned();
            $table->foreign('id_flexibilidad')->references('id')->on('flexibilidads');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->date('fecha_gestion')->nullable();
            $table->text('detalle_revision');
            $table->integer('id_estado');
            $table->integer('id_creador')->unsigned();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas')->nullable();
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
