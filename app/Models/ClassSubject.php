<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSubject extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $primaryKey = 'id';


    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function classStudent()
    {
        return $this->belongsTo(ClassStudent::class, 'id', 'class_id');
    }

}
