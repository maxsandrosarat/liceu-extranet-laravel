<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planejamento extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->hasMany('App\Models\AnexoPlanejamento')
            ->select( \DB::raw('serie') )
            ->groupBy('serie')
            ->orderBy('serie');
    }
}
