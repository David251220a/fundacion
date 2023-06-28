<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaVario extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detalle()
    {
        return $this->hasMany(CuentaVarioDetalle::class, 'cuenta_vario_id');
    }

    public function detalle_pago()
    {
        return $this->hasMany(CuentaVarioDetalle::class, 'cuenta_vario_id')->where('saldo','>', 0);
    }
}
