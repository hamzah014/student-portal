<?php

namespace App\Http\Controllers;

use App\DataTables\ExamSessionDataTable;
use App\Models\ExamSession;
use App\Models\StudentAnswer;
use App\Models\StudentAttempt;
use App\Services\DropdownService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    protected $dropDownService;

    public function __construct()
    {

        $this->dropDownService = new DropdownService();
    }

    public function index(ExamSessionDataTable $datatable)
    {
        return $datatable->render('exam.index');
    }

    public function view(ExamSession $examSession)
    {
        $studentAttempt = $examSession->myStudentAttempt(Auth::user()->id)->first();

        $studentAnswer = [];
        $studentAnswerResult = [];

        if($studentAttempt){

            $studentAnswer = StudentAnswer::where('attempt_id', $studentAttempt->id)->get()
                            ->mapWithKeys(function ($item) {
                                return [ 'answ-' . $item->quest_id => $item->answer_choice];
                            })->toArray();

            $studentAnswerResult = StudentAnswer::where('attempt_id', $studentAttempt->id)->get()
                            ->mapWithKeys(function ($item) {
                                return [ 'answ-' . $item->quest_id => $item->is_correct ?? null];
                            })->toArray();
        }

        return view('exam.view',compact(
            'examSession','studentAttempt','studentAnswer','studentAnswerResult'
        ));

    }

    public function saveSession(Request $request)
    {
        
        try {
            
            DB::beginTransaction();

            $id = $request->id;
            $examSession = ExamSession::where('id', $id)->first();

            if($examSession){
                $studentAttempt = new StudentAttempt();
                $studentAttempt->student_id = Auth::user()->id;
                $studentAttempt->session_id = $examSession->id;
                $studentAttempt->start_at = Carbon::now();
                $studentAttempt->updated_at = Carbon::now();
                $studentAttempt->save();
            }

            DB::commit();
            
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

    public function submit(Request $request,ExamSession $examSession)
    {

        try {
            DB::beginTransaction();

            $studentId = Auth::user()->id;
            $attemptId = $request->attemptId;

            $questionIndex = $request->questionIndex ?? [];
            $answers = $request->answers ?? [];

            foreach($questionIndex as $qIndex){

                $questId =  str_replace('answ-', '', $qIndex);

                $studentAnswer = StudentAnswer::where('attempt_id', $attemptId)->where('quest_id', $questId)->first();
                if(!$studentAnswer){
                    $studentAnswer = new StudentAnswer();
                    $studentAnswer->attempt_id = $attemptId;
                    $studentAnswer->quest_id = $questId;
                }

                $studentAnswer->answer_choice = $answers[$qIndex];
                $studentAnswer->save();

            }

            $studentAttempt = StudentAttempt::where('id', $attemptId)->first();
            $studentAttempt->end_at = Carbon::now();
            $studentAttempt->last_updated = Carbon::now();
            $studentAttempt->submit_at = Carbon::now();
            $studentAttempt->save();

            DB::commit();

            flash('Successfully submit the answer.')->success();
            return redirect()->route('exam.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }

    }

}
