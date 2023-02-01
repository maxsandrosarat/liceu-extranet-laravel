<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeDiaria extends Model
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

    public function anexos()
    {
        return $this->hasMany('App\Models\AnexoAtividadeDiaria');
    }
}
