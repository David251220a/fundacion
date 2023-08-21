<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function insumo()
    {
        return $this->hasMany(PagoVarios::class, 'insumo_id')->where('estado_id', 1)->latest();
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
