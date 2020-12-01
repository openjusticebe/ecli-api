<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'label_fr' => $this->label_fr,
            'label_nl' => $this->label_nl,
            'courts' => $this->courts
        ];
    }
}