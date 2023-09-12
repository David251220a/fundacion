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

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuario_modif()
    {
        return $this->belongsTo(User::class, 'modif_user_id');
    }
}
