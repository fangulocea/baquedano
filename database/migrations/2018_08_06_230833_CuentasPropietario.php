<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CuentasPropietario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
              Schema::dropIfExists('post_cuentaspropietarios');
        Schema::create('post_cuentaspropietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_propietario');
            $table->integer('id_creador');
            $table->integer('id_modificador')->nullable();
            $table->integer('id_asignacion')->nullable();
            $table->integer('id_estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('post_cuentaspropietarios');
    }
}
