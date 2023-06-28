<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoAlumno extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function estado_alumno()
    {
        return $this->belongsTo(CursoAEstado::class, 'curso_a_estado_id');
    }

    public function curso_habilitado(){
        return $this->belongsTo(CursoHabilitado::class, 'curso_habilitado_id');
    }
}
