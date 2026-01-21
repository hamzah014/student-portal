<?php

namespace App\Http\Controllers\Lecturer;

use App\DataTables\Lecturer\MyClassDataTable;
use App\DataTables\Lecturer\MyClassStudentDataTable;
use App\Http\Controllers\Controller;
use App\Models\ClassStudent;
use App\Models\ClassSubject;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSubjectController extends Controller
{
    protected $dropDownService;

    public function __construct()
    {

        $this->dropDownService = new DropdownService();
    }

    public function index(MyClassDataTable $datatable)
    {
        return $datatable->render('lecturer.class.index');
    }

    public function view(MyClassStudentDataTable $dataTable,ClassSubject $classSubject)
    {
        $listLecturer = $this->dropDownService->lecturerList();
        $lectId = Auth::user()->id;
        $classStudent = ClassStudent::whereHas('classSubject', function ($query) use ($lectId, $classSubject) {
                $query->where('lecturer_id', $lectId)->where('class_id', $classSubject->id);
            })->get();

        return view('lecturer.class.view',compact(
            'classSubject', 'listLecturer', 'classStudent'
        ));

    }

}
