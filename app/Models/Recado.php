<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recado extends Model
{
    use HasFactory;
    
    public function aluno(){
        return $this->belongsTo('App\Models\Aluno');
    }

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }
}
