<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulado extends Model
{
    use HasFactory;
    
    public function series()
    {
        return $this->hasMany('App\Models\Questao')
            ->select( \DB::raw('turma_id') )
            ->groupBy('turma_id')
            ->orderBy('turma_id');
    }

}
