<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;
    
    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }
    
    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }

    function aluno(){
        return $this->belongsToMany("App\Models\Aluno", "atividade_retornos");
    }

    public function retornos()
    {
        return $this->hasMany('App\Models\AtividadeRetorno')
            ->select( \DB::raw('aluno_id') )
            ->groupBy('aluno_id')
            ->orderBy('aluno_id');
    }
}
