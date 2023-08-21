<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pago_instructor()
    {
        return $this->hasMany(PagoInstructor::class, 'pago_id');
    }

    public function pago_empleado()
    {
        return $this->hasMany(PagoEmpleado::class, 'pago_id');
    }

    public function pago_varios()
    {
        return $this->hasMany(PagoVarios::class, 'pago_id');
    }

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo_pago()
    {
        return $this->belongsTo(PagoTipo::class, 'pago_tipo_id');
    }
}
