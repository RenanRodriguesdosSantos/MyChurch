<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventoStatus;
use App\Models\User;
use App\Models\MembresiaEventos;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = ['nome', 'data', 'evento_status_id', 'user_id'];

    use HasFactory;

    protected $appends = [
        'status_nome',
        'user_nome',
        'data_input'
    ];


    public function status(){ 
        return $this->belongsTo(EventoStatus::class,'evento_status_id'); 
    }

    public function user(){ 
        return $this->belongsTo(User::class); 
    }

    public function getDataInputAttribute(){ 
        return str_replace(' ','T',$this->data); 
    }

    public function getStatusNomeAttribute(){
        return  $this->status->nome;
    }

    public function getUserNomeAttribute(){
        return  $this->user->name;
    }

    public function participantes(){ 
        return $this->hasMany(MembresiaEventos::class,'evento_id'); 
    }
}
