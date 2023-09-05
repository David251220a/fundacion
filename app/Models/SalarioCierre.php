<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarioCierre extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function tipo_pago()
    {
        return $this->belongsTo(PagoTipo::class, 'pago_tipo_id');
    }
}
