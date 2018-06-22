<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Provincias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('provincias');
          Schema::create('provincias', function (Blueprint $table) {
            $table->increments('provincia_id');
            $table->string('provincia_nombre');
            $table->integer('region_id');
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
         Schema::dropIfExists('provincias');
    }
}
