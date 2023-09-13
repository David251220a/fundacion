<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarioCierre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tipo_pago()
    {
        return $this->belongsTo(PagoTipo::class, 'pago_tipo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalle()
    {
        return $this->hasMany(SalarioCierreDetalle::class, 'salario_cierre_id');
    }
}
