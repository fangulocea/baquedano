<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioRegistrafinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatario_registrafin');
        Schema::create('arrendatario_registrafin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinalarr');

            $table->integer('id_cap_arrendatario')->unsigned();
            $table->foreign('id_cap_arrendatario')->references('id')->on('arrendatarios');

            $table->integer('id_arrendatario')->unsigned();
            $table->foreign('id_arrendatario')->references('id')->on('personas');            

            $table->date('fecha')->nullable();            
            $table->integer('garantia')->nullable();
            $table->integer('reserva')->nullable();
            
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
        Schema::dropIfExists('arrendatario_registrafin');
    }
}
