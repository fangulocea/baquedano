<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('Arrendatarios');
        Schema::create('Arrendatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_arrendatario')->unsigned()->nullable();
            $table->foreign('id_arrendatario')->references('id')->on('personas');
            $table->integer('id_inmueble')->unsigned()->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');   
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas');        
            $table->integer('id_estado');
            $table->string('preferencias')->nullable();
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
        Schema::dropIfExists('Arrendatarios');
    }
}
