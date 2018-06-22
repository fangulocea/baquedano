<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaptacionGestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('cap_gestion');
            Schema::create('cap_gestion', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_captacion_gestion')->unsigned();
                $table->foreign('id_captacion_gestion')->references('id')->on('cap_publicaciones');
                $table->string('tipo_contacto');
                $table->string('dir');
                $table->text('detalle_contacto');
                $table->integer('id_creador_gestion')->nullable();
                $table->integer('id_modificador_gestion')->nullable();
                $table->date('fecha_gestion')->nullable();
                $table->string('hora_gestion')->nullable();
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
        Schema::dropIfExists('cap_gestion');
    }
}
