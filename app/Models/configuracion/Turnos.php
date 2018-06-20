<?php

namespace App\Models\configuracion;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    public $timestamps = false;
    protected $table = 'turno';
    protected $primaryKey='id_turno';
}
