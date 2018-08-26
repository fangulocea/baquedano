<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleCuentasArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::dropIfExists('post_detallecuentas');
        Schema::create('post_detallecuentas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cuenta')->nullable();
            $table->integer('id_idcliente')->nullable();
            $table->string('idcliente')->nullable();
             $table->double('valor_medicion',20,8)->nullable();
            $table->integer('id_contrato');
            $table->integer('id_inmueble');
            $table->integer('id_arrendatario')->nullable();
             $table->integer('id_propietario')->nullable();
            $table->integer('id_creador');
            $table->integer('id_serviciobasico');
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
             $table->integer('diasproporcionales')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_contrato');
             $table->date('fecha_iniciolectura')->nullable();
             $table->date('fecha_finlectura')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->integer('monto_boleta');
            $table->integer('monto_responsable')->nullable();
            $table->integer('procesado')->nullable();
            $table->string('responsable')->nullable();
             $table->string('solicitudpago')->nullable();
            $table->integer('id_estado');
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
        Schema::dropIfExists('post_detallecuentas');
    }
}
