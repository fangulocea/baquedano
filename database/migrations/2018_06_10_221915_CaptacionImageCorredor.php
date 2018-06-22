<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaptacionImageCorredor extends Migration
{
    public function up()
    {
        Schema::dropIfExists('cap_imagecorredor');
        Schema::create('cap_imagecorredor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_capcorredor')->unsigned();
            $table->foreign('id_capcorredor')->references('id')->on('cap_corredores');
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
        Schema::dropIfExists('cap_imagecorredor');
    }
}
