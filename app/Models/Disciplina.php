<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;
    
    function turmas(){
        return $this->belongsToMany("App\Models\Turma", "turma_disciplinas");
    }

    function profs(){
        return $this->belongsToMany("App\Models\Prof", "prof_disciplinas");
    }

}

