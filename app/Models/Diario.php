<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    use HasFactory;

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }
    
    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }

    public function prof(){
        return $this->belongsTo('App\Models\Prof');
    }
}
