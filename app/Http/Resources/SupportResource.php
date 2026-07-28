<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "public_id"=> $this->public_id,
            "title_support" => $this->title_support,
            "message_support" => $this->message_support,
            "type_support" => $this->type_support,
            "status_support"=> $this->status_support,
            "issued_at"=> $this->issued_at,

            "student_sender" => [
                "name" => $this->student->name,
                "email" => $this->student->email,
                "url_image_profile" => $this->student->url_image_profile,
            ]
        ];
    }
}
