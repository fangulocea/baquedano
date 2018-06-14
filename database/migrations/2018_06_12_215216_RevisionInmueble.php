<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevisionInmueble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::dropIfExists('adm_revisioninmueble');
            Schema::create('adm_revisioninmueble', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_inmueble')->unsigned();
                $table->foreign('id_inmueble')->references('id')->on('inmuebles');
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
       Schema::dropIfExists('adm_revisioninmueble');
    }
}
