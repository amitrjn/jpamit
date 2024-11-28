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
            'duration_weeks' => $this->duration_weeks,
            'is_active' => $this->is_active,
            'image_url' => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'created_by' => $this->created_by,
            'creator' => $this->whenLoaded('creator'),
            'trainings' => $this->whenLoaded('trainings'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 