<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->hasMany('App\Models\ConteudoProva')
            ->select( \DB::raw('serie') )
            ->groupBy('serie')
            ->orderBy('serie');
    }
}
