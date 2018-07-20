<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropietarioGarantia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propietario_garantia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('cap_publicaciones');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->string('mes')->nullable();
            $table->integer('ano')->nullable();
            $table->string('banco')->nullable();
            $table->string('numero')->nullable();
            $table->integer('valor')->nullable();
            $table->date('fecha_cobro')->nullable();
            $table->string('id_estado')->nullable();
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
        Schema::dropIfExists('propietario_garantia');
    }
}
