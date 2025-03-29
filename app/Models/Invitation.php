<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    // Definir os tipos de dados dos campos
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

