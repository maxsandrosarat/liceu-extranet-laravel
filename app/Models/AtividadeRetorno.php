<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeRetorno extends Model
{
    use HasFactory;
    
    public function atividade(){
        return $this->belongsTo('App\Models\Atividade');
    }

    public function aluno(){
        return $this->belongsTo('App\Models\Aluno');
    }
}
