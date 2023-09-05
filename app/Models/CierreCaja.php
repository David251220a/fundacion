<?php

namespace App\Models;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'cierre_caja_id');
    }

    public function egresos ()
    {
        return $this->hasMany(Egreso::class, 'cierre_caja_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'cajero');
    }
}
