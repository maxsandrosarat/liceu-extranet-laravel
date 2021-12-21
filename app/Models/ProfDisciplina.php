<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfDisciplina extends Model
{
    use HasFactory;

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }

    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }

    function profTurmas(){
        return $this->belongsToMany("App\Models\Turma", "prof_turmas");
    }
}
