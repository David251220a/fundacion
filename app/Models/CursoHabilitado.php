<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoHabilitado extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tipo_curso()
    {
        return $this->belongsTo(TipoCurso::class, 'tipo_curso_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'curso_habilitado_id');
    }

    public function alumnos_cursando()
    {
        return $this->hasMany(CursoAlumno::class, 'curso_habilitado_id')->whereIn('curso_a_estado_id',[1, 2]);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function insumos()
    {
        return $this->hasMany(CursoIngreso::class, 'curso_habilitado_id')->where('estado_id', 1);
    }

}
