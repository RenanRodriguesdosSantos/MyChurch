<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criado_por')->comment('Usuario que criou a visita');
            $table->datetime('data_visita');
            $table->unsignedBigInteger('responsavel')->nullable();
            $table->text('endereco');
            $table->text('observacoes')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
            $table->foreign('criado_por')->references('id')->on('users');
            $table->foreign('responsavel')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status_visitas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
