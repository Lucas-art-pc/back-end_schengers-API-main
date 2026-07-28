<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceCoursesShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->public_id,
            'title' => $this->title_course,
            'description' => $this->description_course,
            'duration' => $this->duration_course,
            'active_course' => (bool)$this->active_course,
            'image' => $this->url_image_course,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'updated_at' => $this->updated_at?->format('Y-m-d'),

            'area' => $this->whenLoaded('area', fn() => [
                'name' => $this->area->name_area,
            ]),

            'teacher' => $this->whenLoaded('teacher', fn() => [
                'name' => $this->teacher->name,
            ]),
        ];
    }

}
