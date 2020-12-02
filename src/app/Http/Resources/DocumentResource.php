<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'type' -> $this->type,
            'year' -> (int)$this->year,
            'court' => new CourtResource($this->court),
        ];
    }
}