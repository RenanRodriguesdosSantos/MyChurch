<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCestasBasicasToVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitas', function (Blueprint $table) {
            $table->integer('qtde_cesta_basicas')->default(0);
            $table->unsignedBigInteger('membro_visitado')->nullable();
            $table->foreign('membro_visitado')->references('id')->on('membresia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitas', function (Blueprint $table) {
            //
            $table->dropForeign(['qtde_cesta_basicas']);
            $table->dropColumn('qtde_cesta_basicas');
            $table->dropColumn('membro_visitado');
        });
    }
}
