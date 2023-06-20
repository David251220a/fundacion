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
}
