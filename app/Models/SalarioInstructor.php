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
}
