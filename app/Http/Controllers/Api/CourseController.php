<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        // Remove all middleware
    }

    public function index()
    {
        $courses = Course::with('creator')
            ->latest()
            ->paginate(10);

        return CourseResource::collection($courses);
    }

    public function store(CourseRequest $request)
    {
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'created_by' => $request->created_by,
            'image_url' => $request->hasFile('image') 
                ? $request->file('image')->store('courses', 'public')
                : null
        ]);

        return new CourseResource($course);
    }

    public function show(Course $course)
    {
        return new CourseResource($course->load(['creator', 'trainings']));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'is_active' => $request->boolean('is_active')
        ]);

        if ($request->hasFile('image')) {
            $course->update([
                'image_url' => $request->file('image')->store('courses', 'public')
            ]);
        }

        return new CourseResource($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }
} 