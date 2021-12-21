<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadeComplementarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades_complementares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prof_id');
            $table->foreign('prof_id')->references('id')->on('profs');
            $table->unsignedBigInteger('turma_id');
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->unsignedBigInteger('disciplina_id');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
            $table->date('data')->nullable();
            $table->string('descricao')->nullable();
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
        Schema::dropIfExists('atividades_complementares');
    }
}
