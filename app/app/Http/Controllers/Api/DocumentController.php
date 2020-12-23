<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Court;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function show($court_acronym, $year, $type_num)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        if (isset($type_num)) {
            $arr_type_num = explode('.', $type_num, 2);
        }

        $document = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->where('type', $arr_type_num[0])
        ->where('num', $arr_type_num[1])
        ->with('court')
        ->firstOrfail();

        return new DocumentResource($document);
    }
    
    public function docsFilter($court_acronym, Request $request)
    {
        return $request;

        // $court = Court::whereAcronym($court_acronym)->firstOrFail();

        // $documents = Document::whereCourtId($court->id)
        // ->where('type', $type)
        // ->paginate(20);

        // return DocumentResource::collection($documents);
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
