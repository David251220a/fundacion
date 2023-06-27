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
}
