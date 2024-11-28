<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.organizer')->except(['index', 'show']);
    }

    public function index()
    {
        $courses = Course::with('creator')
            ->when(!Auth::user()->isOrganizer(), function ($query) {
                return $query->where('is_active', true);
            })
            ->latest()
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(CourseRequest $request)
    {
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'created_by' => Auth::id(),
            'image_url' => $request->hasFile('image') 
                ? $request->file('image')->store('courses', 'public')
                : null
        ]);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['creator', 'trainings']);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

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

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
} 