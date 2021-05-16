<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembrosEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membresia_eventos', function (Blueprint $table) {
            $table->unsignedBigInteger('membro_id');
            $table->unsignedBigInteger('evento_id')->nullable();
            $table->foreign('membro_id')->references('id')->on('membresia');
            $table->foreign('evento_id')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membresia_eventos');
    }
}
