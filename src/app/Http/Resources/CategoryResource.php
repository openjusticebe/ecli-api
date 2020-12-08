<?php

namespace App\Http\Resources;

class CategoryResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'label_fr' => $this->label_fr,
            'label_nl' => $this->label_nl,
            'label_de' => $this->label_de,
            'courts' => CourtResource::collection($this->whenLoaded('courts'))
        ];
    }
}
