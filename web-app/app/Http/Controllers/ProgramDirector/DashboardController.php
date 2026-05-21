<?php

namespace App\Http\Controllers\ProgramDirector;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('program_director.dashboard');
    }
}
