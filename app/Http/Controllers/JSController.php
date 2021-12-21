<?php

namespace App\Http\Controllers;
use App\Models\ProfDisciplina;
use App\Models\ProfTurma;
use App\Models\Turma;

use Illuminate\Http\Request;

class JSController extends Controller
{
    public function turmas(Request $request)
    {
        $profDisc = ProfDisciplina::where('prof_id',"$request->prof")->where('disciplina_id',"$request->disc")->first();
        $profTurmas = ProfTurma::where('prof_disciplina_id',"$profDisc->id")->get();
        $turmas = array();
        foreach($profTurmas as $profTurma){
            $turmas[] = $profTurma->turma_id;
        }
        return Turma::whereIn('id', $turmas)->where('ativo',true)->get();
    }

    public function funcAgends(Request $request){
        $count = Agendamento::where('data',"$request->dia")->where('hora',"$request->hora")->where('func_id',"$request->id")->where('status','PENDENTE')->count();
        return $count;
    }

    public function clienteAgends(Request $request){
        $cliente = User::where('email',"$request->id")->first();
        $count = Agendamento::where('data',"$request->dia")->where('hora',"$request->hora")->where('user_id',"$cliente->id")->where('status','PENDENTE')->count();
        return $count;
    }
}
