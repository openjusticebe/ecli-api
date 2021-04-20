<?php

namespace App\Http\Resources;

use App\Models\Court;
use App\Models\Document;
use URL;
use Cache;
class HomePageResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'title' => "A free open source solution developed by OpenJustice.be to browse Belgian case law.",
            'recent_documents' => [
                'title' => 'Recent documents',
                'documents' => Cache::remember('recent_documents', 3600, function () {
                    return DocumentMinimalResource::collection(Document::orderBy('created_at', 'desc')->limit(10)->get());
                }),
            ],
            'court_categories' => [
                'title' => 'Browse categories and courts',
                'categories' => Cache::remember('court_categories_rsrc', 3600 * 240, function () {
                    return CategoryResource::collection($this);
                }),
            ],
            'count_documents' => Cache::remember('count_documents', 3600 * 120, function () {
                return Document::count();
            }),
            'count_courts' => Cache::remember('count_courts', 3600 * 120, function () {
                return Court::count();
            }),
            'links' => [
                'self' => URL::current(),
            ],
            ];
    }
}
