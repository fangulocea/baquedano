<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioImg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('arrendatarioimgs');
        Schema::create('arrendatarioimgs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_arrendatario')->unsigned();
            $table->foreign('id_arrendatario')->references('id')->on('arrendatarios');
            $table->string('descripcion')->nullable();
            $table->string('nombre');
            $table->string('ruta');
            $table->string('id_creador')->nullable();
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
        Schema::dropIfExists('arrendatarioimgs');
    }
}
