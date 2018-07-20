<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioGarantia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatario_garantia');
        Schema::create('arrendatario_garantia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacion')->unsigned()->nullable();
            $table->foreign('id_publicacion')->references('id')->on('arrendatarios');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');
            $table->string('mes')->nullable();
            $table->integer('ano')->nullable();
            $table->string('banco')->nullable();
            $table->string('numero')->nullable();
            $table->integer('valor')->nullable();
            $table->string('id_estado')->nullable();
            $table->date('fecha_cobro')->nullable();
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
        Schema::dropIfExists('arrendatario_garantia');
    }
}
