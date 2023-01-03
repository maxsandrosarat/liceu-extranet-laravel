<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LancamentoNota extends Model
{
    use HasFactory;

    public function nota(){
        return $this->belongsTo('App\Models\Nota');
    }

    public function aluno(){
        return $this->belongsTo('App\Models\Aluno');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
