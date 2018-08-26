<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PresupuestoPostVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('post_presupuesto');
            Schema::create('post_presupuesto', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_postventa')->nullable();
                $table->integer('id_inmueble')->nullable();
                $table->integer('id_propietario')->nullable();
                $table->integer('id_arrendatario')->nullable();
                $table->integer('id_creador')->nullable();
                $table->integer('id_solicitud')->nullable();
                $table->integer('id_modificador')->nullable();
                $table->string('responsable_pago')->nullable();
                $table->integer('id_responsable_pago')->nullable();
                $table->integer('total')->nullable();
                $table->integer('id_estado')->nullable();
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
        Schema::dropIfExists('post_presupuesto');
    }
}
