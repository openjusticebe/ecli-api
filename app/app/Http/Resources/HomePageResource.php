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

            'title' => null,
            'recent_documents' => [
                'title' => 'Recent documents',
                'documents' => DocumentMinimalResource::collection(Document::orderBy('created_at', 'desc')->limit(10)->get()),
            ],
            'court_categories' => [
                'title' => 'Browse categories and courts',
                'categories' => CategoryResource::collection($this),
            ],
            'count_documents' => Document::count(),
            'count_courts' => Court::count(),
            'links' => [
                'self' => URL::current(),
            ],
            ];
    }
}
