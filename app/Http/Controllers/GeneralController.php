<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general.index')->only('index');
    }

    public function index()
    {
        return view('general.index');
    }
}
