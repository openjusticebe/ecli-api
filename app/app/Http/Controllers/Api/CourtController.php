<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CourtResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\CourtDocumentsPageResource;
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

    
    /**
 * @OA\Get(
 * path="/ECLI/BE/{court_acronym}",
 * summary="Get Court",
 * description="Get list of Court",
 * operationId="geoZipCodes",
 * tags={"Court"},
 * security={ {"bearer": {} }},
 * @OA\Response(
 *    response=200,
 *    description="Success"
 * )
 * )
 */
    
    public function show($court_acronym)
    {
        return new CourtResource(Court::whereAcronym($court_acronym)->with('category')
            ->firstOrFail());
    }
}
