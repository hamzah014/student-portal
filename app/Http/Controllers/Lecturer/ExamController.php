<?php

namespace App\Http\Controllers\Lecturer;

use App\DataTables\Lecturer\ExamSessionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\SaveExamRequest;
use App\Models\ClassSubject;
use App\Models\ExamSession;
use App\Models\QuestionExam;
use App\Models\QuestionOption;
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
        return $datatable->render('lecturer.exam.index');
    }

    public function create()
    {
        $subjectList = $this->dropDownService->getClassSubject(Auth::user()->id);
        $formRoute = route('lect.exam.store');

        $examSession = new ExamSession();
        $type = 'create';

        return view('lecturer.exam.create',compact(
            'subjectList', 'formRoute', 'examSession', 'type'
        ));

    }

    public function store(SaveExamRequest $request)
    {
        try {

            DB::beginTransaction();

            $examSession = new ExamSession();
            $examSession->title = $request->title;
            $examSession->class_id = $request->class_id;
            $examSession->duration_min = $request->duration_min;
            $examSession->start_at = $request->start_at;
            $examSession->end_at = $request->end_at;
            $examSession->save();

            DB::commit();

            flash('Successfully save the data.')->success();
            return redirect()->route('lect.exam.edit', $examSession->id);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }

    }

    public function edit(ExamSession $examSession)
    {

        $subjectList = $this->dropDownService->getClassSubject(Auth::user()->id);
        $formRoute = route('lect.exam.update', $examSession->id);
        $type = 'edit';

        $questions = QuestionExam::where('session_id', $examSession->id)->get();
        $questionType = $this->dropDownService->question_type();

        return view('lecturer.exam.edit',compact(
            'subjectList', 'formRoute', 'examSession', 'type',
            'questions','questionType'
        ));

    }

    
    public function update(SaveExamRequest $request, ExamSession $examSession)
    {
        try {

            DB::beginTransaction();

            $examSession->title = $request->title;
            $examSession->class_id = $request->class_id;
            $examSession->duration_min = $request->duration_min;
            $examSession->start_at = $request->start_at;
            $examSession->end_at = $request->end_at;
            $examSession->save();

            DB::commit();

            flash('Successfully save the data.')->success();
            return redirect()->route('lect.exam.edit', $examSession->id);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }

    }
    
    public function updateQuestion(Request $request, ExamSession $examSession)
    {
        try {

            DB::beginTransaction();

            $questionIndex = $request->questionIndex ?? [];
            $questions = $request->questions;
            $data = [];

            foreach($questionIndex as $qindex){
                array_push($data,$questions[$qindex]);

                $existId = str_replace('qi-', '', $qindex);
                $data = $questions[$qindex];
                $title = $data['title'];
                $type = $data['type'];

                $questionExam = QuestionExam::where('id', $existId)->first();

                if(!$questionExam){
                    $questionExam = new QuestionExam();
                }

                $questionExam->session_id = $examSession->id;
                $questionExam->quest_type = $type;
                $questionExam->quest_text = $title;
                $questionExam->save();

                if($type == 'mcq'){
                    $options = $data['options'] ?? [];

                    if(!isset($data['correct']))
                    {
                        DB::rollBack();
                        flash('Please select one as answer.')->error();            
                        return redirect()->back();
                    }

                    $correctId = $data['correct'];

                    foreach($options as $index => $opt){
                        $is_answer = $index == $correctId ? 1 : 0;

                        $existOpt = str_replace('opt-', '', $index);

                        $questionOption = QuestionOption::where('id', $existOpt)->first();

                        if(!$questionOption)
                            $questionOption = new QuestionOption();

                        $questionOption->quest_id = $questionExam->id;
                        $questionOption->option_text = $opt;
                        $questionOption->is_answer = $is_answer;
                        $questionOption->save();
                    }
                }

            }

            DB::commit();

            flash('Successfully save the data.')->success();
            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }

    }

    public function removeQuestion(Request $request)
    {
        try {
            
            DB::beginTransaction();

            $id = $request->id;

            $questionExam = QuestionExam::where('id', $id)->delete();
            $questionOption = QuestionOption::where('quest_id', $id)->delete();

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

    public function listAttempt(ExamSession $examSession)
    {
        $studentAttempt = StudentAttempt::where('session_id', $examSession->id)->get();
        return view('lecturer.exam.attempt_list',compact(
            'studentAttempt'
        ));
    }

    public function detailAttempt(StudentAttempt $studentAttempt)
    {
        $examSession = $studentAttempt->examSession;
        $student = $studentAttempt->student;

        $studentAnswer = [];

        if($studentAttempt){

            $studentAnswer = StudentAnswer::where('attempt_id', $studentAttempt->id)->get()
                            ->mapWithKeys(function ($item) {
                                $data = array(
                                    'answ-' . $item->quest_id => [
                                        'id' => $item->id,
                                        'choice' => $item->answer_choice,
                                        'correct' => $item->is_correct ?? null
                                    ]
                                );
                                return $data;
                            })->toArray();
        }

        $answerStatus = $this->dropDownService->answer_status();

        return view('lecturer.exam.attempt_detail',compact(
            'studentAttempt','examSession','studentAnswer','student','answerStatus'
        ));
    }

    public function submitResult(Request $request)
    {
        // dd($request->all());
        $studentAttempt = StudentAttempt::where('id', $request->attemptId)->first();

        try {
            DB::beginTransaction();

            $answers = $request->answers ?? [];
            $correct = 0;

            foreach($answers as $ansIndex => $answer){
                $studentAnswer = StudentAnswer::where('id', $answer['answerid'])->first();

                if(!isset($answer['correct'])){
                    DB::rollBack();
                    flash('Please complete all result.')->error();            
                    return redirect()->back();
                }

                if($answer['correct'] == 1)
                    $correct++;

                if($studentAnswer){
                    $studentAnswer->is_correct = $answer['correct'];
                    $studentAnswer->save();
                }
            }
            
            $percentage = ($correct / count($answers)) * 100;

            $studentAttempt->result_at = Carbon::now();
            $studentAttempt->score = $percentage;
            $studentAttempt->save();

            DB::commit();

            flash('Successfully submit the result.')->success();
            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Error: ' . $th->getMessage())->error();
            return redirect()->back();
        }

    }

}
