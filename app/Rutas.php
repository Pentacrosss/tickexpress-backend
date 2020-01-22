<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    protected $table='rutas';
    protected $fillable = ['placa_bus','lugar_salida','lugar_destino','hora','precio'];
}
