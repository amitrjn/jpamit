<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'created_by' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['created_by'] = 'exists:users,id';
        }

        return $rules;
    }
} 