<?php

namespace App\Models\configuracion;

use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.modulos';
    protected $primaryKey='id_mod';
}
