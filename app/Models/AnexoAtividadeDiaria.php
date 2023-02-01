<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoAtividadeDiaria extends Model
{
    use HasFactory;

    public function atividade_diaria(){
        return $this->belongsTo('App\Models\AtividadeDiaria');
    }
}
