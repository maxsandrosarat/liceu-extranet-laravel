<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoAtividadeComplementar extends Model
{
    use HasFactory;

    public function atividade_complementar(){
        return $this->belongsTo('App\Models\AtividadeComplementar');
    }
    
    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
