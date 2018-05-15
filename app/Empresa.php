<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresa";

    protected $fillable = [
        'nombre',
        'razon_social',
        'rut',
        'direccion',
        'cuenta_pago'
    ];
}
