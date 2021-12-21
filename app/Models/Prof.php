<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Prof extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $guard = 'prof';
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function disciplinas(){
        return $this->belongsToMany("App\Models\Disciplina", "prof_disciplinas");
    }

    function discs(){
        return $this->belongsToMany("App\Models\ProfDisciplina", "prof_disciplinas");
    }

}
