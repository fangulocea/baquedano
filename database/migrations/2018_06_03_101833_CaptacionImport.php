<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaptacionImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('cap_import');
            Schema::create('cap_import', function (Blueprint $table) {
                $table->increments('id');
                $table->string('CAPTADOR')->nullable();
                $table->string('Fecha_publicacion')->nullable();
                $table->string('Direccion')->nullable();
                $table->string('Nro')->nullable();
                $table->string('Dpto')->nullable();
                $table->string('Comuna')->nullable();
                $table->string('Dorm')->nullable();
                $table->string('Bano')->nullable();
                $table->string('Esta')->nullable();
                $table->string('Bode')->nullable();
                $table->string('Pisc')->nullable();
                $table->string('Precio')->nullable();
                $table->string('GASTOS_COMUNES')->nullable();
                $table->string('CONDICION')->nullable();
                $table->string('nombre_propietario')->nullable();
                $table->string('TELEFONO')->nullable();
                $table->string('correo')->nullable();
                $table->string('portal')->nullable();
                $table->string('FECHA_ENVIO_CLIENTE')->nullable();
                $table->string('OBSERVACIONES')->nullable();
                $table->text('LINK')->nullable();
                $table->string('Codigo_Publicacion')->nullable();
                $table->string('id_creador')->nullable();
                $table->integer('id_estado')->nullable();
                $table->string('ob_estado')->nullable();
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
        Schema::dropIfExists('cap_import');
    }
}
