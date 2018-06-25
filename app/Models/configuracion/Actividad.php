<?php

namespace App\Models\configuracion;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    public $timestamps = false;
    protected $table = 'actividad';
    protected $primaryKey='id_actividad';
}
