<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ciudad()
    {
        return $this->hasMany(Ciudad::class, 'departamento_id');
    }
}
