<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConteudoProva extends Model
{
    use HasFactory;
    protected $table = 'conteudos_provas';

    public function prova(){
        return $this->belongsTo('App\Models\Prova');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
