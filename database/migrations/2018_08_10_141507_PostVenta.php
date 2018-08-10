<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('post_venta');
        Schema::create('post_venta', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('id_modulo')->nullable();
            $table->integer('id_contrato')->nullable();
            $table->integer('id_inmueble')->nullable();
            $table->integer('id_propietario')->nullable();
            $table->integer('id_arrendatario')->nullable();
            $table->integer('id_administradoredificio')->nullable();
            $table->integer('id_aval')->nullable();
            $table->integer('id_creador')->nullable();
            $table->integer('id_modificador')->nullable();
            $table->integer('id_asignacion')->nullable();
            $table->integer('id_estado')->nullable();
            $table->integer('meses_contrato')->nullable();
            $table->date('fecha_contrato')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_revision')->nullable();
            $table->date('fecha_seguimiento')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->string('nombre_caso')->nullable();
            $table->longText('descripcion_del_caso')->nullable();
            $table->string('id_cobro')->nullable();
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
        Schema::dropIfExists('post_venta');
    }
}
