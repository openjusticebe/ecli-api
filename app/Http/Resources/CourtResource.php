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
            'documents_count' => $this->documents_count,
            'years_count' =>  $this->documents->groupBy('year')->count(),
            'first_year' => $this->documents->min('year'),
            'last_year' =>  $this->documents->max('year'),
            'year' -> $this->year;
            'languages_document' => [
                'fr' => 98e3, 
                'nl' => 88273, 
                'de' => 173
            ],      
            'types_document' => [
                'arr' => 98e3, 
                'dec' => 88273, 
                'de' => 173
            ],
            'year_count' => null,
        ];
    }
}