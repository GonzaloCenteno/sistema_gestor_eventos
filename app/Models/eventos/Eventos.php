<?php

namespace App\Models\eventos;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    public $timestamps = false;
    protected $table = 'eventos.eventos';
    protected $primaryKey='id_evento';
}
