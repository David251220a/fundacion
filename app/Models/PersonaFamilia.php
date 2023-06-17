<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaFamilia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tipo_familiar()
    {
        return $this->belongsTo(TipoFamilia::class, 'tipo_familia_id');
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'partido_id');
    }
}
