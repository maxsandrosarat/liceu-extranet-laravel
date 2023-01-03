<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->hasMany('App\Models\LancamentoNota')
            ->select( \DB::raw('turma_id') )
            ->groupBy('turma_id')
            ->orderBy('turma_id');
    }
}
