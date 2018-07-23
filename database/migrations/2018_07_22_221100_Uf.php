<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('adm_uf');
        Schema::create('adm_uf', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('dia')->nullable();
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->double('valor', 20, 8)->nullable();
            $table->integer('id_creador')->nullable();
            $table->integer('id_modificador')->nullable();
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
      Schema::dropIfExists('adm_uf');
    }
}
