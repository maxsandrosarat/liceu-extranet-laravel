<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aluno extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $guard = 'aluno';
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function turma(){
        return $this->belongsTo('App\Models\Turma');
    }

    function atividade(){
        return $this->belongsToMany("App\Models\Atividade", "atividade_retornos");
    }
}
