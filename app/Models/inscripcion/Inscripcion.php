<?php

namespace App\Models\inscripcion;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    public $timestamps = false;
    protected $table = 'inscripcion';
    protected $primaryKey='id_inscripcion';
}
