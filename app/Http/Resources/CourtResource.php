<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourtResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'acronym' => $this->acronym,
            'name_nl' => $this->name_nl,
            'name_de' => $this->name_de,
            'name_fr' => $this->name_fr,
            'href' => null,
            'logo_href' => null,
            'category' => $this->category,
            'documents_count' => (int)$this->documents_count,
            'years_count' =>  (int)$this->documents->groupBy('year')->count(),
            'first_year' => (int)$this->documents->min('year'),
            'last_year' =>  (int)$this->documents->max('year'),
            // 'year' -> $this->year,
            'languages_document' => [
                'fr' => null, 
                'nl' => null, 
                'de' => null
            ],      
            // 'type' => PostResource::collection($this->posts),
            'types_document' => [
                'arr' => null, 
                'dec' => null, 
                'de' => null
            ],
            'year_count' => null,
        ];
    }
}