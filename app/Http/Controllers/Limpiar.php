<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Limpiar extends Controller
{
    public function limpiar()
    {
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('route:clear');
        \Artisan::call('migrate');
        \Artisan::call('db:seed');
    }

    public function acceso()
    {
        $target = '/home/zaqptb99qumc/laravel/storage/app/public';
        $shortcut = '/home/zaqptb99qumc/public_html/storage';
        symlink($target, $shortcut);
    }
}
