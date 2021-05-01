<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'visitas';
    protected $fillable = ['criado_por', 'data_visita', 'responsavel', 'endereco', 'observacoes', 'status_id','descricao'];

    public function criadoPor() {
        return $this->belongsTo(User::class, 'criado_por');
    }
    public function responsavel() {
        return $this->belongsTo(User::class, 'responsavel');
    }
    public function status() {
        return $this->belongsTo(StatusVisitas::class, 'status_id');
    }
    use HasFactory;
}
