<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetallePresupuestoPostVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('post_detallepresupuesto');
            Schema::create('post_detallepresupuesto', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_presupuesto')->nullable();
                $table->integer('id_proveedor')->nullable();
                $table->integer('id_familia')->nullable();
                $table->integer('id_item')->nullable();
                $table->integer('id_creador')->nullable();
                $table->integer('id_modificador')->nullable();
                $table->double('valor_proveedor',20,8)->nullable();
                $table->double('valor_unitario_baquedano',20,8)->nullable();
                $table->double('recargo',10,8)->nullable();
                $table->integer('cantidad')->nullable();
                $table->double('monto_baquedano',20,8)->nullable();
                $table->double('monto_proveedor',20,8)->nullable();
                $table->double('subtotal',20,8)->nullable();
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
        Schema::dropIfExists('post_detallepresupuesto');
    }
}
