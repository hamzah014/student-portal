<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSession extends Model
{
    use HasFactory;

    protected $table = 'exam_sessions';
    protected $primaryKey = 'id';

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(QuestionExam::class, 'session_id');
    }

    public function myStudentAttempt($userid)
    {
        return $this->hasOne(StudentAttempt::class, 'session_id')->where('student_id', $userid);
    }


}
