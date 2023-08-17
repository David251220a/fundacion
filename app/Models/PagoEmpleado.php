<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoEmpleado extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function concepto()
    {
        return $this->belongsTo(SalarioConcepto::class, 'salario_concepto_id');
    }
}
