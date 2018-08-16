<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('post_itemmateriales');
            Schema::create('post_itemmateriales', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_familia')->nullable();
                $table->string('item')->nullable();
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
       Schema::dropIfExists('post_itemmateriales');
    }
}
