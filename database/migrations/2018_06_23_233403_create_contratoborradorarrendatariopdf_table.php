<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoborradorarrendatariopdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contratoborradorarrendatariospdf');
        Schema::create('contratoborradorarrendatariospdf', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_b_arrendatario')->unsigned();
            $table->foreign('id_b_arrendatario')->references('id')->on('contratoborradorarrendatarios');
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
        Schema::dropIfExists('contratoborradorarrendatariospdf');
    }
}
