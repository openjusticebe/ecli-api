<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Document;
use App\Http\Resources\DocumentResource;

use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CourtResource;

class DocumentController extends Controller
{
    public function show($court_acronym, $year, $type, $num)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $document = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->where('num', $num)
        ->where('type', $type)
        ->firstOrfail();

        return new DocumentResource($document);
    }


    public function docsRecent($court_acronym)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

        return DocumentResource::collection($documents);
    }


    public function docsPerYear($court_acronym, $year)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->paginate(20);
        
        return DocumentResource::collection($documents);
    }

    public function docsPerLang($court_acronym, $lang)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        $documents = Document::whereCourtId($court->id)
        ->where('lang', $lang)
        ->paginate(20);

        return DocumentResource::collection($documents);
    }

    public function docsPerType($court_acronym, $type)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('type', $type)
        ->paginate(20);

        return DocumentResource::collection($documents);
    }
}
