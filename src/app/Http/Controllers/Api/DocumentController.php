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
    public function show($court_acronym, $year, $type, $num)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        return Document::whereCourtId($court->id)
        ->where('year', $year)
        ->where('num', $num)
        ->where('type', $type)
        ->firstOrfail();
        // return new CourtResource(Court::whereAcronym($court_acronym)->with(['category', 'documents'])
        //     ->firstOrFail());
    }
}
