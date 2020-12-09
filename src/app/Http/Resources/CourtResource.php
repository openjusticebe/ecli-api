<?php

namespace App\Http\Resources;

class CourtResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'acronym' => $this->acronym,
            'name' => $this->name,
            'name_i18ns' => [
                'name_nl' => $this->name_nl,
                'name_de' => $this->name_de,
                'name_fr' => $this->name_fr,

            ],
            'court_href' => $this->court_href,
            'logo_href' => $this->logo_href,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'count_total' => (int)$this->docs_per_year->sum('count'),
            'first_year' => (int)$this->docs_per_year->min('year'),
            'last_year' =>  (int)$this->docs_per_year->max('year'),
            'year_count' =>  (int)$this->docs_per_year->count('year'),
            'type_count' =>  (int)$this->docs_per_type->count('type'),
            'lang_count' =>  (int)$this->docs_per_lang->count('lang'),
            'docs_per_year' => $this->docs_per_year,
            'docs_per_type' => $this->docs_per_type,
            'docs_per_lang' => $this->docs_per_lang,
            'links' => route('courts.show', ['court_acronym' => $this->acronym])
        ];
    }
}
