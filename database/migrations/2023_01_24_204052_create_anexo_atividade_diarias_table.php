<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexoAtividadeDiariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo_atividade_diarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atividade_diaria_id');
            $table->foreign('atividade_diaria_id')->references('id')->on('atividade_diarias');
            $table->string('arquivo')->nullable();
            $table->string('descricao')->nullable();
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
        Schema::dropIfExists('anexo_atividade_diarias');
    }
}
