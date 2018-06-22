<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comunas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('comunas');
           Schema::create('comunas', function (Blueprint $table) {
            $table->increments('comuna_id');
            $table->string('comuna_nombre');
            $table->integer('provincia_id');
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
        Schema::dropIfExists('comunas');
    }
}
