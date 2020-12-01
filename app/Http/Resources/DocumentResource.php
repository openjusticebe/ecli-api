<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' -> $this->type,
            'year' -> $this->year,
            'court' => new CourtResource($this->court),
        ];
    }
}