<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function egreso($param)
    {
        return $this->hasMany(SalarioInstructor::class, 'instructor_id')
        ->where('curso_habilitado_id', $param)
        ->where('estado_id', 1)
        ->where('tipo', 2);
    }

}
