<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusVisitas extends Model
{
    protected $table = 'status_visitas';
    protected $filllable = ['descricao', 'slug'];
    public $timestamps = false;
    use HasFactory;
}
