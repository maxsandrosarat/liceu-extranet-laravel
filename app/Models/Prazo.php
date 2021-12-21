<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prazo extends Model
{
    use HasFactory;

    public function simulado(){
        return $this->belongsTo('App\Models\Simulado');
    }
}
