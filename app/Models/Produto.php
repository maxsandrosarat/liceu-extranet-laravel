<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function listaCompra(){
        return $this->belongsToMany("App\Models\ListaCompra", "compra_produtos");
    }
}
