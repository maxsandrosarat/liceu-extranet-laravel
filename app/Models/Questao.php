<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;
    protected $table = 'questoes';

    public function simulado(){
        return $this->belongsTo('App\Models\Simulado');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
