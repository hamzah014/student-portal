<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMyClass = ClassStudent::where('student_id', Auth::user()->id)->where('status','approve')->count();
        return view('dashboard',compact(
            'totalMyClass'
        ));
    }    

}
