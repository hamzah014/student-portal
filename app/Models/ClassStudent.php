<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassStudent extends Model
{
    use HasFactory;

    protected $table = 'class_student';
    protected $primaryKey = 'id';

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    

}
