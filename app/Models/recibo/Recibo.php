<?php

namespace App\Models\recibo;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    public $timestamps = false;
    protected $table = 'recibo';
    protected $primaryKey='id_recibo';
}
