<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoMatriculaDetalle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function curso_habilitado()
    {
        return $this->belongsTo(CursoHabilitado::class, 'curso_habilitado_id');
    }

    public function ingreso_matricula()
    {
        return $this->belongsTo(IngresoMatricula::class, 'ingreso_matricula_id');
    }
}
