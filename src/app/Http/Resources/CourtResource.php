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
            'category' => $this->whenPivotLoaded('category', function () {
                return $this->category();
            }),
            'documents_count' => (int)$this->docs_per_year->sum('documents_count'),
            'first_year' => (int)$this->docs_per_year->min('year'),
            'last_year' =>  (int)$this->docs_per_year->max('year'),
            'docs_per_year' => $this->docs_per_year,
            'docs_per_type' => $this->docs_per_type,

            // 'docsPerYear' => $this->whenPivotLoaded('docsPerYear', function () {
            //     return $this->docsPerYear();
            // }),
        ];
    }
}
