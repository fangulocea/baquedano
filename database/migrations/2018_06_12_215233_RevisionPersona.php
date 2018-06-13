<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevisionPersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::dropIfExists('adm_revisionpersona');
            Schema::create('adm_revisionpersona', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_persona')->unsigned();
                $table->foreign('id_persona')->references('id')->on('personas');
                $table->string('tipo_revision');
                $table->text('detalle_revision');
                $table->integer('id_creador')->nullable();
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
         Schema::dropIfExists('adm_revisionpersona');
    }
}
