<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimulaArrendatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('cap_simulaarrendatario');
        Schema::create('cap_simulaarrendatario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacion')->nullable();
            $table->integer('id_inmueble')->nullable();
            $table->integer('id_arrendatario')->nullable();
            $table->integer('meses_contrato')->nullable();
            $table->date('fecha_iniciocontrato')->nullable();
            $table->string('proporcional')->nullable();
            $table->integer('dia')->nullable();
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->double('iva', 20, 8)->nullable();
            $table->double('descuento', 20, 8)->nullable();
            $table->double('pie', 20, 8)->nullable();
            $table->double('cobromensual', 20, 8)->nullable();
            $table->integer('tipopropuesta')->nullable();
            $table->integer('nrocuotas')->nullable();
            $table->integer('gastocomun')->nullable();
            $table->integer('notaria')->nullable();
            $table->integer('otro1')->nullable();
            $table->integer('otro2')->nullable();
            $table->string('nomotro1')->nullable();
            $table->string('nomotro2')->nullable();
            $table->string('moneda')->nullable();
            $table->double('valormoneda', 20, 8)->nullable();
            $table->integer('id_creador')->nullable();
            $table->integer('id_modificador')->nullable();
            $table->integer('id_estado')->nullable();
            $table->double('canondearriendo', 20, 8)->nullable();
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
        Schema::dropIfExists('cap_simulaarrendatario');
    }
}
