<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CurriculumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'public_id'               => $this->public_id,
            'name'                    => $this->name,
            'email'                   => $this->email,
            'phone'                   => $this->phone,
            'linkedin'                => $this->linkedin,
            'portfolio'               => $this->portfolio,
            'education_level'         => $this->education_level,
            'institution'             => $this->institution,
            'course'                  => $this->course,
            'graduation_year'         => $this->graduation_year,
            'professional_experience' => $this->professional_experience,
            'skills'                  => $this->skills,
            'personal_document'       => $this->personal_document
                ? Storage::url($this->personal_document)
                : null,
            'professional_document'   => $this->professional_document
                ? Storage::url($this->professional_document)
                : null,
            'status'                  => $this->status,
            'created_at'              => $this->created_at?->format('d/m/Y'),

            // Relacionamentos — só aparecem se carregados com with()
            'teacher' => $this->whenLoaded('teacher', fn() => [
                'name'  => $this->teacher->name,
                'email' => $this->teacher->email,
            ]),

            'vacancy' => $this->whenLoaded('vacancy', fn() => [
                'public_id' => $this->vacancy->public_id,
                'title'     => $this->vacancy->title_vacancy,
                'slug'      => $this->vacancy->slug_vacancy,
            ]),
        ];
    }
}
