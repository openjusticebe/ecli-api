<?php

namespace App\Http\Resources;

use URL;

class CourtDocumentsPageResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'court' => new CourtResource($this->first()->court),
            'category' => new CategoryResource($this->first()->court->category),
            'documents' => DocumentResource::collection($this),
            'links' => [
                'self' => URL::current(),
                'parent' => null
            ]
            ];
    }
}
