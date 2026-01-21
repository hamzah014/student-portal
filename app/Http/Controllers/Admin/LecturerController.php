<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LecturerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveLectRequest;
use App\Models\User;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{

    protected $dropDownService;

    public function __construct()
    {

        $this->dropDownService = new DropdownService();
    }

    public function index(LecturerDataTable $datatable)
    {
        return $datatable->render('admin.lecturer.index');
    }

    public function create()
    {
        $type = 'create';
        $lecturer = new User();
        $formRoute = route('admin.lect.create');
        return view('admin.lecturer.create', compact(
            'lecturer',
            'formRoute',
            'type'
        ));
    }

    public function store(SaveLectRequest $request)
    {

        try {

            DB::beginTransaction();

            $lectRole = User::LECTURER_ROLE;
            $referCode = generateRandomString();

            $lecturer = new User();
            $lecturer->name  = $request->name;
            $lecturer->email = $request->email;
            $lecturer->password = '123';
            $lecturer->role = $lectRole;
            $lecturer->refer_code = $referCode;
            $lecturer->save();

            DB::commit();

            flash('Successfully save the data.')->success();
            return redirect()->route('admin.lect.edit', $lecturer->id);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }
    }

    public function edit(User $lecturer)
    {

        $status_lect = $this->dropDownService->status_lecturer();

        $type = 'edit';
        $formRoute = route('admin.lect.update', $lecturer);
        return view('admin.lecturer.create', compact(
            'lecturer',
            'formRoute',
            'type',
            'status_lect'
        ));
    }

    public function update(SaveLectRequest $request, User $lecturer)
    {

        try {

            DB::beginTransaction();

            $lecturer->name  = $request->name;
            $lecturer->email = $request->email;
            $lecturer->save();

            DB::commit();

            flash('Successfully update the data.')->success();
            return redirect()->route('admin.lect.edit', $lecturer->id);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }
    }
}
