<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentCourseResource extends JsonResource
{
    public function __construct(
        $resource,
        protected array $completedClassIds = [],
        protected array $completedActivityIds = [],
        protected bool $isCourseCompleted = false
    ) {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            "public_id"        => $this->public_id,
            "fk_id_teacher"    => $this->fk_id_teacher,
            "title_course"     => $this->title_course,
            "description_course" => $this->description_course,
            "duration_course"   => $this->duration_course,
            "active_course" => $this->active_course,
            "slug_course"      => $this->slug_course,
            "url_image_course" => $this->url_image_course,
            "is_completed_course" => $this->isCourseCompleted,

            "area" => [
                'name_area' => $this->area?->name_area,
                'slug_area' => $this->area?->slug_area,
            ],

            "classes" => $this->classes->map(fn($class) => [
                "title_class"       => $class->title_class,
                "public_id"         => $class->public_id,
                "explication_class"        => $class->explication_class,
                "description_class" => $class->description_class,
                "duration_class"    => $class->duration_class,
                "url_class"       => $class->url_class,
                "is_completed"      => in_array($class->id_class, $this->completedClassIds),
            ]),

            // No resource — expanda o map de activities
            "activities" => $this->activities->map(fn($activity) => [
                "title_activity"       => $activity->title_activity,
                "public_id"            => $activity->public_id,
                "slug_activity"        => $activity->slug_activity,
                "description_activity" => $activity->description_activity,
                "question_activity" => $activity->question_activity,
                "is_completed"         => in_array($activity->id_activity, $this->completedActivityIds),

                "alternatives" => $activity->alternatives->map(fn($alt) => [
                    "id_alternative"    => $alt->id_alternative,
                    "title_alternative" => $alt->title_alternative,
                    "text_alternative"  => $alt->text_alternative,
                    "correct_alternative" => $alt->correct_alternative,
                ]),
            ]),
        ];
    }
}
