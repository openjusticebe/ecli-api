<?php

namespace App\Http\Resources;

class CategoryResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'label' => $this->label,
            'label_i18ns' => [
                'label_fr' => $this->label_fr,
                'label_nl' => $this->label_nl,
                'label_de' => $this->label_de,
            ],
            'courts' => CourtMinimalResource::collection($this->whenLoaded('courts')),
        ];
    }
}
