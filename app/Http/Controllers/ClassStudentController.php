<?php

namespace App\Http\Controllers;

use App\DataTables\Lecturer\MyClassStudentDataTable;
use App\DataTables\ListClassSubjectDataTable;
use App\DataTables\MyClassSubjectDataTable;
use App\Models\ClassStudent;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassStudentController extends Controller
{
    public function index(MyClassSubjectDataTable $datatable)
    {
        return $datatable->render('myclass.index');
    }

    public function list(ListClassSubjectDataTable $datatable)
    {
        return $datatable->render('myclass.list');
    }

    public function requestJoin(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id'  => ['required'],
            'type'  => ['required', 'in:approve,request,withdraw'],
            'userid'  => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->getMessageBag()->toArray(),
                'success' => false, 
                'type' => 'error'
            ], 400);
        }

        $id = $request->id;
        if(in_array($request->type, ['request','withdraw'])){
            $classSubject = ClassSubject::where('id', $id)->first();

            if(!$classSubject){
                return response()->json([
                    'message' => 'Subject class not valid.',
                    'success' => false, 
                    'type' => 'error'
                ], 500);
            }
        }

        try {
            
            DB::beginTransaction();
            
            $type = $request->type;

            if($type == 'request'){
                $classStudent = new ClassStudent();
                $classStudent->class_id = $classSubject->id;
                $classStudent->student_id = $request->userid;
                $classStudent->status = $type;
                $classStudent->save();

                $message = 'Successfully request to join.';
            }

            if($type == 'withdraw'){
                $deleteAll = ClassStudent::where('class_id', $id)
                            ->where('student_id', $request->userid)
                            ->delete();

                $message = 'Successfully withdraw the class.';
            }

            if($type == 'approve'){
                $classStudent = ClassStudent::where('id', $id)
                            ->first();
                $classStudent->status = 'approve';
                $classStudent->save();


                $message = 'Successfully approve the student.';
            }

            DB::commit();

            flash(__($message))->success();
            
            return response()->json([
                'message' => 'Success',
                'success' => true, 
                'type' => 'success'
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => 'Error: ' . $th->getMessage(),
                'success' => false, 
                'type' => 'error'
            ], 500);
        }

    }

}
