<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoMatricula extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detalle()
    {
        return $this->hasMany(IngresoMatriculaDetalle::class, 'ingreso_matricula_id');
    }
}
