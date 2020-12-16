<?php

namespace App\Http\Resources;

use App\Models\Court;
use App\Models\Document;
use URL;

class HomePageResource extends BaseResource
{
    public function toArray($request)
    {
        return [

            'title' => 'Browse categories and courts',
            'title_i18ns' => [
                'title_de' => 'Durchsuchen Sie Kategorien',
                'title_fr' => 'Parcourir les catégories, cours et les tribunaux',
                'title_nl' => 'Blader door categorieën en banen',
            ],
            'categories' => CategoryResource::collection($this),
            'count_documents' => Document::count(),
            'count_courts' => Court::count(),
            'links' => [
                'self' => URL::current(),
                'parent' => null,
            ],
            ];
    }
}
