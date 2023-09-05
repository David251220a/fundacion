<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }

    public function ingreso_tipo()
    {
        return $this->belongsTo(IngresoTipo::class, 'ingreso_tipo_id');
    }
}
