<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GestionPostVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::dropIfExists('post_gestion');
            Schema::create('post_gestion', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_postventa')->nullable();
                $table->string('tipo_contacto')->nullable();
                $table->string('contacto_con')->nullable();
                $table->string('detalle_contacto')->nullable();
                $table->text('detalle_gestion');
                $table->integer('id_creador')->nullable();
                $table->integer('id_gestionador')->nullable();
                $table->integer('id_modificador')->nullable();
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
        //
    }
}
