<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CourtResource;
use App\Http\Resources\DocumentResource;
use App\Models\Document;

class CourtController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return CourtResource::collection(Court::get());
    }

    public function show($court_acronym)
    {
        return new CourtResource(Court::whereAcronym($court_acronym)->with('category')
            ->firstOrFail());
    }


    public function docsPerYear($court_acronym, $year)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->with('court.category')
        ->get();
        
        return DocumentResource::collection($documents);
    }

    public function docsPerLang($court_acronym, $lang)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        $documents = Document::whereCourtId($court->id)
        ->where('lang', $lang)
        ->with('court.category')
        ->get();

        return DocumentResource::collection($documents);
    }

    public function docsPerType($court_acronym, $type)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('type', $type)
        ->with('court.category')
        ->get();

        return DocumentResource::collection($documents);
    }
}
