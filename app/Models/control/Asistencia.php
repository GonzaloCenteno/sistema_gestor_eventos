<?php

namespace App\Models\control;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    public $timestamps = false;
    protected $table = 'asistencia';
    protected $primaryKey='id_asistencia';
}
