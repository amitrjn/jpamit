<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'training_id' => $this->training_id,
            'training' => $this->whenLoaded('training'),
            'date' => $this->date,
            'duration_minutes' => $this->duration_minutes,
            'order' => $this->order,
            'materials_url' => $this->materials_url ? asset('storage/' . $this->materials_url) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 