<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class CursoIngreso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function alumnos()
    {
        return $this->hasMany(CursoInAlumno::class, 'curso_ingreso_id')->where('estado_id', 1);
    }
}
