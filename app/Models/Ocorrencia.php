<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    use HasFactory;

    public function tipo_ocorrencia(){
        return $this->belongsTo('App\Models\TipoOcorrencia');
    }

    public function aluno(){
        return $this->belongsTo('App\Models\Aluno');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }

    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }
}
