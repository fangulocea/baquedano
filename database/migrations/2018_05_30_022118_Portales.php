<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Portales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('portales');
            Schema::create('portales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('estado');
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
        Schema::dropIfExists('portales');
    }
}
