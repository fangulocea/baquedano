<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChkinmueblefotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chkinmueblefoto');
        Schema::create('chkinmueblefoto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chk')->unsigned();
            $table->foreign('id_chk')->references('id')->on('chkinmuebles');
            $table->integer('id_inmueble')->unsigned();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->string('descripcion');
            $table->string('nombre');
            $table->string('ruta');
            $table->integer('id_item')->unsigned();
            $table->foreign('id_item')->references('id')->on('checklist');
            $table->string('id_creador')->nullable();
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
        Schema::dropIfExists('chkinmueblefoto');
    }
}
