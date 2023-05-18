<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(NoticiaFile::class, 'noticia_id');
    }

    public function tag()
    {
        return $this->hasMany(NoticiaTag::class, 'noticia_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function file_video()
    {
        return $this->hasMany(NoticiaFile::class, 'noticia_id')->where('tipo', 2)->where('estado_id',1);
    }

    public function files_fotos()
    {
        return $this->hasMany(NoticiaFile::class, 'noticia_id')->where('tipo', 1)->where('estado_id',1);
    }
}
