<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoStatus extends Model
{
    protected $table = 'evento_status';

    protected $fillable = ['nome'];
    
    public $timestamps = false;

    use HasFactory;
}
