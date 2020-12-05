<?php

namespace App\Http\Resources;

use URL;

class HomePageResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'title_en' => 'Browser categories and courts',
            'title_de' => 'Durchsuchen Sie Kategorien',
            'title_fr' => 'Parcourir les catégories, cours et les tribunaux',
            'title_nl' => 'Blader door categorieën en banen',
            'categories' => CategoryResource::collection($this),
            'links' => [
                'self' => URL::current(),
                'parent' => null
            ]
            ];
    }
}
