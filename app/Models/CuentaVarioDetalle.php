<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaVarioDetalle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function producto()
    {
        return $this->belongsTo(IngresoConcepto::class, 'ingreso_concepto_id');
    }
}
