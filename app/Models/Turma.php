<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;
    
    function disciplinas(){
        return $this->belongsToMany("App\Models\Disciplina", "turma_disciplinas")->orderBy('nome');
    }
}
