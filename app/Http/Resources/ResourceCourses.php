<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceCourses extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->public_id,
            'slug' => $this->slug_course,

            'title' => $this->title_course,
            'duration' => $this->duration_course,
            'active' => $this->active_course,
            'image' => $this->url_image_course,

            'total_classes' => $this->classes_count,
            'total_activities' => $this->activities_count,

            'area' => [
                'name' => $this->area?->name_area,
                'slug' => $this->area?->slug_area,
            ],

            'teacher' => [
                'name' => $this->teacher?->name,
            ],
        ];
    }
}
