<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'membresia';

    protected $fillable = ['nome', 'email', 'nome', 'cpf', 'telefone', 'email', 'databatismo', 'foto'];

    public $timestamps = false;

    use HasFactory;
}
