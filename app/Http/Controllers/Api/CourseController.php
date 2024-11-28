<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::with('creator');

        // Add search functionality
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Add filtering by status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $courses = $query->latest()->paginate($request->per_page ?? 10);
        return CourseResource::collection($courses);
    }

    /**
     * Store a new course
     */
    public function store(CourseRequest $request)
    {

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'created_by' => $request->created_by,
            'is_active' => $request->boolean('is_active', true),
            'image_url' => $request->hasFile('image') 
                ? $request->file('image')->store('courses', 'public')
                : null
        ]);

        return new CourseResource($course);
    }

    /**
     * Display a specific course
     */
    public function show(Course $course)
    {
        return new CourseResource($course->load(['creator', 'trainings']));
    }

    /**
     * Update a course
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'is_active' => $request->boolean('is_active')
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image_url) {
                Storage::disk('public')->delete($course->image_url);
            }
            
            $course->update([
                'image_url' => $request->file('image')->store('courses', 'public')
            ]);
        }

        return new CourseResource($course);
    }

    /**
     * Delete a course
     */
    public function destroy(Course $course)
    {
        // Delete course image if exists
        if ($course->image_url) {
            Storage::disk('public')->delete($course->image_url);
        }
        
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }

    /**
     * Toggle course status
     */
    public function toggleStatus(Course $course)
    {
        $course->update([
            'is_active' => !$course->is_active
        ]);

        return new CourseResource($course);
    }

    /**
     * Bulk delete courses
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:courses,id'
        ]);

        Course::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Courses deleted successfully']);
    }
} 