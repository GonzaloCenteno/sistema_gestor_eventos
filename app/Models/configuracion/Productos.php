<?php

namespace App\Models\configuracion;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    public $timestamps = false;
    protected $table = 'productos';
    protected $primaryKey='id_producto';
}
