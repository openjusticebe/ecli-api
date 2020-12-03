<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Document;

use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CourtResource;

class DocumentController extends Controller
{
    public function perYear($court_acronym, $year)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        return Document::whereCourtId($court->id)
        ->where('year', $year)
        ->get();
        // return new CourtResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }

    public function perLang($court_acronym, $lang)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        return Document::whereCourtId($court->id)
        ->where('lang', $lang)
        ->get();

        // return new CourtResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }

    public function perType($court_acronym, $type)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        return Document::whereCourtId($court->id)
        ->where('type', $type)
        ->get();

        // return new CourtResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }
}
