<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'duration_weeks' => $this->duration_weeks,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'trainings' => TrainingResource::collection($this->whenLoaded('trainings')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
} 