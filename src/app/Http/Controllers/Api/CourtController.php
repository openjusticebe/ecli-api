<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CourtResource;
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

        return Document::whereCourtId($court->id)
        ->where('year', $year)
        ->get();
        // return DocumentResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }

    public function docsPerLang($court_acronym, $lang)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        return Document::whereCourtId($court->id)
        ->where('lang', $lang)
        ->get();

        // return DocumentResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }

    public function docsPerType($court_acronym, $type)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        return Document::whereCourtId($court->id)
        ->where('type', $type)
        ->get();

        // return DocumentResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }
}
