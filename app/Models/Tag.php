<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function noticias_tag()
    {
        return $this->hasMany(NoticiaTag::class, 'tag_id');
    }
}
