<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitaParticipanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita_participante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visita_id');
            $table->unsignedBigInteger('participante_id');
            $table->foreign('visita_id')->references('id')->on('visitas');
            $table->foreign('participante_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visita_participante', function (Blueprint $table) {
            //
        });
    }
}
