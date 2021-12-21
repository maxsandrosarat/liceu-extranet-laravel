<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaAtividade extends Model
{
    use HasFactory;

    public function disciplina(){
        return $this->belongsTo('App\Models\Disciplina');
    }
}
