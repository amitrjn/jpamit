<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Http\Resources\TrainingResource;
use App\Http\Requests\TrainingRequest;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::with(['course', 'lessons']);
        
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $trainings = $query->latest()->paginate($request->per_page ?? 10);
        return TrainingResource::collection($trainings);
    }

    public function store(TrainingRequest $request)
    {
        $training = Training::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return new TrainingResource($training);
    }

    public function show(Training $training)
    {
        return new TrainingResource($training->load(['course', 'lessons']));
    }

    public function update(TrainingRequest $request, Training $training)
    {
        $training->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active'),
        ]);

        return new TrainingResource($training);
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return response()->json(['message' => 'Training deleted successfully']);
    }
} 