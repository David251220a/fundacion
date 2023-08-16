<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarioInstructor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function concepto()
    {
        return $this->belongsTo(SalarioConcepto::class, 'salario_concepto_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function curso_habilitado()
    {
        return $this->belongsTo(CursoHabilitado::class, 'curso_habilitado_id');
    }
}
