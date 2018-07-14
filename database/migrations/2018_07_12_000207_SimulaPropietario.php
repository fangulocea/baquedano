<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimulaPropietario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cap_simulapropietario');
        Schema::create('cap_simulapropietario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_inmueble')->unsigned();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('id_propietario')->unsigned();
            $table->foreign('id_propietario')->references('id')->on('personas');
            $table->integer('meses_contrato')->nullable();
            $table->date('fecha_iniciocontrato')->nullable();
            $table->string('proporcional')->nullable();
            $table->integer('dia')->nullable();
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->string('moneda')->nullable();
            $table->double('valormoneda', 20, 8)->nullable();
            $table->integer('id_creador')->nullable();
            $table->integer('id_modificador')->nullable();
            $table->integer('id_estado')->nullable();
            $table->double('canondearriendo', 20, 8)->nullable();
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
        Schema::dropIfExists('cap_simulapropietario');
    }
}
