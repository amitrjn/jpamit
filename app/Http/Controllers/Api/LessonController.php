<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    public function index(): JsonResponse
    {
        $lessons = Lesson::with('training')->get();
        return response()->json($lessons);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'training_id' => 'required|uuid|exists:trainings,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'zoom_meeting_id' => 'nullable|string'
        ]);

        $lesson = Lesson::create($validated);
        return response()->json($lesson, 201);
    }

    public function show(Lesson $lesson): JsonResponse
    {
        return response()->json($lesson->load('training', 'attendances'));
    }

    public function update(Request $request, Lesson $lesson): JsonResponse
    {
        $validated = $request->validate([
            'training_id' => 'sometimes|required|uuid|exists:trainings,id',
            'title' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
            'zoom_meeting_id' => 'nullable|string'
        ]);

        $lesson->update($validated);
        return response()->json($lesson);
    }

    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();
        return response()->json(null, 204);
    }
} 