<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('university_admin.dashboard');
    }
}
