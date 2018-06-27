<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    public $timestamps = false;
    protected $table = 'inventario';
    protected $primaryKey='id_inventario';
}
