<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $data = Instructor::take(500)
        ->get();

        return view('instructor.index', compact('data'));
    }

    public function create()
    {
        return view('instructor.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
