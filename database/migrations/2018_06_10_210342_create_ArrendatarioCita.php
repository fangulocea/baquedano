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
        Schema::dropIfExists('ArrendatarioCitas');
        Schema::create('ArrendatarioCitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_arrendatario')->unsigned();
            $table->foreign('id_arrendatario')->references('id')->on('Arrendatarios');
            $table->string('descripcion')->nullable();
            $table->date('fecha');
            $table->string('hora');
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
        Schema::dropIfExists('ArrendatarioCitas');
    }
}
