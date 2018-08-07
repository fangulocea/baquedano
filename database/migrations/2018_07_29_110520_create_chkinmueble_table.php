<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChkinmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chkinmuebles');
        Schema::create('chkinmuebles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_inmueble')->unsigned();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->integer('id_creador')->unsigned()->nullable();
            $table->foreign('id_creador')->references('id')->on('personas');  
            $table->integer('id_modificador')->unsigned()->nullable();
            $table->foreign('id_modificador')->references('id')->on('personas');  
            $table->string('id_estado');
            $table->longText('descripcion')->nullable();
            $table->string('tipo')->nullable();

            $table->integer('id_bor_arr')->unsigned()->nullable();
            $table->foreign('id_bor_arr')->references('id')->on('arrendatarios');

            $table->integer('id_cap_pro')->unsigned()->nullable();
            $table->foreign('id_cap_pro')->references('id')->on('cap_publicaciones');


            $table->integer('id_contrato')->nullable();
            $table->string('e_s_r')->nullable();
            $table->longText('comentarios')->nullable(); 

            $table->date('fecha_limite')->nullable();

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
        
        Schema::dropIfExists('chkinmuebles');
    }
}
