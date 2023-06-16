<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function departamento()
    {
        return $this->hasMany(Departamento::class, 'pais_id');
    }
}
