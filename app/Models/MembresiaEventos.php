<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembresiaEventos extends Model
{
    use HasFactory;
    protected $table = 'membresia_eventos';

    protected $fillable = ['membro_id', 'evento_id'];

    public $timestamps = false;

    public function membro()
    {
        return $this->belongsTo(Membresia::class, 'membro_id');
    }
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
