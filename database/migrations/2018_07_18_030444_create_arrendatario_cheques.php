<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioCheques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatario_cheques');
        Schema::create('arrendatario_cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned()->nullable();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinalarr')->nullable();
            $table->integer('monto')->nullable();
            $table->integer('numero')->nullable();
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
        Schema::dropIfExists('arrendatario_cheques');
    }
}
