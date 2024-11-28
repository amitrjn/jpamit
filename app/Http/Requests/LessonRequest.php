<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'training_id' => 'required|exists:trainings,id',
            'date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
            'materials' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240'
        ];
    }
} 