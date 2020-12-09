<?php

namespace App\Http\Resources;

class CourtMinimalResource extends BaseResource
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
            'links' => route('courts.show', ['court_acronym' => $this->acronym])
        ];
    }
}
