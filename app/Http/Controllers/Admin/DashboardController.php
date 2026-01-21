<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
        $totalLecturer = User::where('role', User::LECTURER_ROLE)->whereNotNull('email_verified_at')->count();
        $totalStudent = User::where('role', User::STUDENT_ROLE)->whereNotNull('email_verified_at')->count();
        $totalClass = ClassSubject::count();
        return view('admin.dashboard',compact(
            'totalClass','totalLecturer','totalStudent'
        ));
    }

}
