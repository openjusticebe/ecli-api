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
}
