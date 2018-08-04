<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mensajes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::dropIfExists('mensajes');
        Schema::create('mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_modulo');
             $table->string('nombre_modulo');
            $table->integer('id_estado');
            $table->string('nombre');
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
        Schema::dropIfExists('mensajes');
    }
}
