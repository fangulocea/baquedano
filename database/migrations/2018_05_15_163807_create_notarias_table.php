<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notarias');
        Schema::create('notarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razonsocial');
            $table->integer('id_comuna');
            $table->integer('id_region');
            $table->integer('id_provincia');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('nombreNotario');
            $table->string('email');
            $table->integer('estado');
            $table->softDeletes();
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
        Schema::dropIfExists('notarias');
    }
}
