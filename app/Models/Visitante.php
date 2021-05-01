<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $table = 'membresia';

    protected $fillable = ['nome', 'telefone', 'tipo', 'observacoes'];

    use HasFactory;
}
