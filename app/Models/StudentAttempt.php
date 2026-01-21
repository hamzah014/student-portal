<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAttempt extends Model
{
    use HasFactory;

    protected $table = 'student_attempt';
    protected $primaryKey = 'id';
    

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
