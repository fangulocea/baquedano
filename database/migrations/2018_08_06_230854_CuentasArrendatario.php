<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CuentasArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('post_cuentasarrendatarios');
        Schema::create('post_cuentasarrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_arrendatario');
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
        Schema::dropIfExists('post_cuentasarrendatarios');
    }
}
