<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsavelAluno extends Model
{
    use HasFactory;

    public function responsavel(){
        return $this->belongsTo('App\Models\Responsavel');
    }

    public function aluno(){
        return $this->belongsTo('App\Models\Aluno');
    }
}
