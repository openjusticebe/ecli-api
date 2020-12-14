<?php

namespace App\Http\Resources;

class UtuResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'term_fr' => $this->term_fr,
            'term_nl' => $this->term_nl,
            'term_de' => $this->term_de,
            'classification_nl' => $this->classiLang('term_fr'),
            'classification_fr' => $this->classiLang('term_nl'),
            'classification_de' => $this->classiLang('term_de'),
            'subcategories' => UtuResource::collection($this->whenLoaded('children'))
        ];
    }
}
