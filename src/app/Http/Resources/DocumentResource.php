<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'type' => $this->type,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'court' => new CourtResource($this->whenLoaded($this->court)),
            'elci' => $this->elci,
            'links' => [
                'default' => null,
                'meta' => null,
                'text' => null,
                'pdf' =>  null,
            ]
        ];
    }
}
