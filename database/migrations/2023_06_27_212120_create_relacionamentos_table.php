<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacionamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_documento');
            $table->unsignedBigInteger('usuario_pai');
            $table->unsignedBigInteger('usuario_filho');
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('id_documento')->references('id')->on('documents');
            $table->foreign('usuario_pai')->references('id')->on('users');
            $table->foreign('usuario_filho')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relacionamentos');
    }
}
