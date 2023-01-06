<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataAplicacaoTableConteudoProvas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conteudos_provas', function (Blueprint $table) {
            $table->date('data_aplicacao')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conteudos_provas', function (Blueprint $table) {
            $table->dropColumn('data_aplicacao');
        });
    }
}
