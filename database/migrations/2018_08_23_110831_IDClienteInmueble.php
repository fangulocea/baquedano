<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IDClienteInmueble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('post_idcliente');
            Schema::create('post_idcliente', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_inmueble')->nullable();
                $table->integer('id_empresaservicio')->nullable();
                $table->integer('id_creador')->nullable();
                $table->integer('id_modificador')->nullable();
                $table->string('idcliente')->nullable();
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
        Schema::dropIfExists('post_idcliente');
    }
}
