<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoTableAtividadeDiarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atividade_diarias', function (Blueprint $table) {
            $table->string('tipo')->default('diaria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atividade_diarias', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
