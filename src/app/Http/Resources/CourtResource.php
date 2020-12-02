<?php

namespace App\Http\Resources;

class CourtResource extends BaseResource
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
            'docsPerType' => $this->docsPerType,
            // 'type' => PostResource::collection($this->posts),
            'docsPerYear' => $this->docsPerYear,
            'year_count' => null,
        ];
    }
}
