<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropietariopagofinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('propietariopagofin');
        Schema::create('propietariopagofin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('adm_contratofinal');
            $table->integer('id_publicacion')->unsigned();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->date('fecha')->nullable();
            $table->double('monto',20,2)->nullable();
            $table->double('saldo',20,2)->nullable();
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
        Schema::dropIfExists('propietariopagofin');
    }
}

