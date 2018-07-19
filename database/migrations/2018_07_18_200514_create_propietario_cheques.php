<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropietarioCheques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('propietario_cheques');
        Schema::create('propietario_cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned()->nullable();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinal')->nullable();
            $table->string('mes_arriendo')->nullable();
            $table->string('banco')->nullable();
            $table->integer('monto')->nullable();
            $table->integer('numero')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->integer('correlativo')->nullable();
            $table->integer('id_estado');
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
        Schema::dropIfExists('propietario_cheques');
    }
}
