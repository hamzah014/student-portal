<?php

namespace App\Services;

use App\Models\ClassSubject;
use App\Models\User;

class DropdownService
{

    public function status_lecturer()
    {
        return [
            'pending' => 'Pending',
            'active' => 'Activate',
        ];
    }

    public function lecturerList()
    {
        $role = User::LECTURER_ROLE;

        $lecturerList = User::orderBy('name', 'ASC')
            ->where('role', $role)
            ->whereNotNull('email_verified_at')
            ->get();

        $data = $lecturerList->mapWithKeys(function ($item) {
            return [$item->id => $item->name . " ( " . $item->email . " )"];
        });

        return $data;
    }

    public function getClassSubject($id)
    {

        $subject = ClassSubject::where('lecturer_id', $id)->get();

        $data = $subject->mapWithKeys(function ($item) {
            return [$item->id => $item->code . " - " . $item->name];
        });

        return $data;

    }
    
    public function question_type()
    {
        return [
            'mcq' => 'Multiple Choice',
            'text' => 'Text',
        ];
    }
    
    public function answer_status()
    {
        return [
            1 => 'Correct',
            0 => 'Wrong',
        ];
    }

}
