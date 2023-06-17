<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function familiares()
    {
        return $this->hasMany(PersonaFamilia::class, 'persona_id')->where('estado_id', 2);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'persona_id');
    }

}
