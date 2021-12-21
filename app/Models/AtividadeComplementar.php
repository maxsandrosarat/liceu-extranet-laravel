<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeComplementar extends Model
{
    use HasFactory;
    
    protected $table = 'atividades_complementares';

    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }
    
    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }

}
