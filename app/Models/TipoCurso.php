<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCurso extends Model
{
    use HasFactory;

    //para guardar todos los campos.
    protected $guarded = [];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
