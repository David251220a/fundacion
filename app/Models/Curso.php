<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modulo()
    {
        return $this->belongsTo(CursoModulo::class, 'curso_modulo_id');
    }

    public function familia()
    {
        return $this->belongsTo(TipoCurso::class, 'tipo_curso_id');
    }

    public function habilitado()
    {
        return $this->hasMany(CursoHabilitado::class, 'curso_id')->where('concluido', 0);
    }

    public function agendado()
    {
        return $this->hasMany(Agenda::class, 'curso_id')->where('curso_a_estado_id', 4);
    }

}
