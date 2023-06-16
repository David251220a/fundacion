<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function barrio()
    {
        return $this->hasMany(Barrio::class, 'ciudad_id');
    }
}
