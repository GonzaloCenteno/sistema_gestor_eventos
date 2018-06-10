<?php

namespace App\Models\configuracion;

use Illuminate\Database\Eloquent\Model;

class Sub_Modulos extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.sub_modulos';
    protected $primaryKey='id_sub_mod';
}
