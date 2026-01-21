<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class SaveExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'  => ['required'],
            'class_id'  => ['required'],
            'duration_min'  => ['required'],
            'start_at'  => ['required'],
            'end_at'  => ['required'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'        => 'Title is required.',
            'class_id.required'     => 'Please select a subject.',
            'start_at.required'     => 'Start session is required.',
            'end_at.required'       => 'End session is required.',
            'duration_min.required' => 'Duration (minutes) is required.',
        ];
    }
}
