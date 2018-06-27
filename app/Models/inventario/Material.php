<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $timestamps = false;
    protected $table = 'materiales';
    protected $primaryKey='id_material';
}
