<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios_u extends Model
{    
    public $timestamps = false;
    protected $table = 'public.users';
    protected $primaryKey='id';
}
