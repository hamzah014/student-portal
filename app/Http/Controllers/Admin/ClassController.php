<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ClassDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveClassRequest;
use App\Http\Requests\Admin\SaveLectRequest;
use App\Models\ClassSubject;
use App\Models\User;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{

    protected $dropDownService;

    public function __construct()
    {

        $this->dropDownService = new DropdownService();
    }

    public function index(ClassDataTable $datatable)
    {
        return $datatable->render('admin.class.index');
    }

    public function create()
    {
        $type = 'create';
        $classSubject = new ClassSubject();
        $formRoute = route('admin.class.create');

        $listLecturer = $this->dropDownService->lecturerList();

        return view('admin.class.create', compact(
            'classSubject',
            'formRoute',
            'type',
            'listLecturer'
        ));
    }

    public function store(SaveClassRequest $request)
    {

        try {

            DB::beginTransaction();

            $classSubject = new ClassSubject();
            $classSubject->code = $request->code;
            $classSubject->name = $request->name;
            $classSubject->lecturer_id = $request->lecturer_id;
            $classSubject->save();

            DB::commit();

            flash('Successfully save the data.')->success();

            return redirect()->route('admin.class.edit', $classSubject->id);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }
    }

    public function edit(ClassSubject $classSubject)
    {
        $type = 'edit';
        $formRoute = route('admin.class.update', $classSubject);
        $listLecturer = $this->dropDownService->lecturerList();

        return view('admin.class.edit', compact(
            'classSubject',
            'formRoute',
            'type',
            'listLecturer'
        ));
    }
    
    public function update(SaveClassRequest $request, ClassSubject $classSubject)
    {

        try {

            DB::beginTransaction();

            $classSubject->code = $request->code;
            $classSubject->name = $request->name;
            $classSubject->lecturer_id = $request->lecturer_id;
            $classSubject->save();

            DB::commit();

            flash('Successfully update the data.')->success();

            return redirect()->route('admin.class.edit', $classSubject->id);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }
    }
}
