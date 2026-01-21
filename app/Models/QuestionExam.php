<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionExam extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $primaryKey = 'id';

    public function questionOption()
    {
        return $this->hasMany(QuestionOption::class, 'quest_id');
    }

}
