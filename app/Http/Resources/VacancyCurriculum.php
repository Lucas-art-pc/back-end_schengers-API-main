<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyCurriculum extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'public_id'   => $this->public_id,
            'title'       => $this->title_vacancy,
            'slug'        => $this->slug_vacancy,
            'status'      => $this->status_vacancy,
            'curriculums' => CurriculumResource::collection(
                $this->whenLoaded('curriculums')
            ),
        ];
    }
}
