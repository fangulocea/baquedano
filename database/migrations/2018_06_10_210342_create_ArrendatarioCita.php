<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrendatarioCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('Arrendatariocitas');
        Schema::create('Arrendatariocitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('numero')->nullable();
            $table->string('departamento')->nullable();
            $table->integer('id_comuna')->nullable();
            $table->integer('id_region')->nullable();
            $table->integer('id_provincia')->nullable();
            $table->string('nombre_c')->nullable();
            $table->string('telefono_c')->nullable();
            $table->string('email_c')->nullable();
            $table->date('fecha');
            $table->integer('id_estado');
            $table->string('id_creador')->nullable();
            $table->integer('id_arrendatario')->unsigned();
            $table->foreign('id_arrendatario')->references('id')->on('arrendatarios');
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
        Schema::dropIfExists('Arrendatariocitas');
    }
}
