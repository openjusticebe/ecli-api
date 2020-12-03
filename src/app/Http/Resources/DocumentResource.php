<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'num' => $this->num,
            'type' => $this->type,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'court' => new CourtResource($this->whenLoaded('court')),
            'elci' => $this->elci,
            'links' => [
                'self' => route('documents.show', ['court_acronym' => $this->court->acronym, 'year' => $this->year, 'type' => $this->type, 'num' => $this->num]),
                'meta' => null,
                'text' => null,
                'pdf' =>  null,
            ]
        ];
    }
}
