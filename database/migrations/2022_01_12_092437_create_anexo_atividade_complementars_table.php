<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexoAtividadeComplementarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo_atividade_complementars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atividade_complementar_id');
            $table->foreign('atividade_complementar_id')->references('id')->on('atividades_complementares');
            $table->unsignedBigInteger('turma_id');
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->unsignedBigInteger('disciplina_id');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
            $table->date('data_utilizacao')->nullable();
            $table->string('arquivo')->nullable();
            $table->boolean('impresso')->default(false);
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
        Schema::dropIfExists('anexo_atividade_complementars');
    }
}
