<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoPlanejamento extends Model
{
    use HasFactory;
    
    public function planejamento(){
        return $this->belongsTo('App\Models\Planejamento');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
