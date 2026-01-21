<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSubject = ClassSubject::where('lecturer_id', Auth::user()->id)->count();
        $totalStudent = ClassSubject::where('lecturer_id', Auth::user()->id)
                        ->whereHas('classStudent', function($query){
                            $query->where('status','approve');
                        })->count();
        return view('lecturer.dashboard',compact(
            'totalStudent','totalSubject'
        ));
    }
}
