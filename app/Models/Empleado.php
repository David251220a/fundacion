<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ingreso()
    {
        return $this->hasMany(SalarioEmpleado::class, 'empleado_id')->where('tipo', 1)->where('estado_id', 1);
    }

    public function salario()
    {
        return $this->hasMany(SalarioEmpleado::class, 'empleado_id')->where('salario_concepto_id', 1)->where('estado_id', 1);
    }

    public function egreso()
    {
        return $this->hasMany(SalarioEmpleado::class, 'empleado_id')->where('tipo', 2)->where('estado_id', 1);
    }

    public function todos()
    {
        return $this->hasMany(SalarioEmpleado::class, 'empleado_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }


}
