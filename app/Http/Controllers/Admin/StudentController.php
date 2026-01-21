<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StudentDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index(StudentDataTable $datatable)
    {
        return $datatable->render('admin.student.index');
    }
}
