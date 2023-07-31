<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoVarios extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function persona ()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function detalle()
    {
        return $this->hasMany(IngresoVariosDetalle::class, 'ingreso_vario_id');
    }

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }

    public function curso()
    {
        return $this->belongsTo(CursoHabilitado::class, 'curso_habilitado_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
