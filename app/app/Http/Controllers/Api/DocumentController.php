<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Court;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function show($court_acronym, $year, $type_identifier)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        if (isset($type_identifier)) {
            $arr_type_identifier = explode('.', $type_identifier, 2);
        }

        $document = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->where('type', $arr_type_identifier[0])
        ->where('identifier', $arr_type_identifier[1])
        ->with('court')
        ->firstOrfail();

        return new DocumentResource($document);
    }

    /**
    * @OA\Post(
    * path="/ECLI/BE/{court_acronym}/docsFilter",
    * tags={"ECLI"},
    * summary="Filter documents of a court",
    * description="Filter documents of a court",
    * operationId="ECLI",
    * @OA\Parameter(
     *          name="court_acronym",
     *          description="Court acronym",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\RequestBody(
     *        description = "data arrays",
     *          required=true,
     *          @OA\JsonContent(
     *   @OA\Property(
     *                property="data",
     *                type="array",
     *     @OA\Items(
     *      @OA\Property(
     *       property="lang",
     *       type="string",
     *       example="['french', 'dutch']"
     *       ),
     * @OA\Property(
     *       property="year",
     *       type="string",
     *       example="['2001', '1983']"
     *       ),
     *  @OA\Property(
     *       property="type",
     *       type="string",
     *       example="['AVIS', 'JUG']"
     *       ),
     *      )
     *      )
     *    )
     * ),
     * https://github.com/zircote/swagger-php/issues/728
    * security={ {"bearer": {} }},
    * @OA\Response(
    *    response=200,
    *    description="Success",
    * )
    * )
    * )
    */
    
    public function docsFilter($court_acronym, Request $request)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->whereIn('lang', $request->lang)
        ->whereIn('type', $request->type)
        ->whereIn('year', $request->year)
        ->paginate(20);

        return DocumentResource::collection($documents);
    }

    public function docsRecent($court_acronym)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->orderBy('year', 'desc')
        ->orderBy('identifier', 'desc')
        ->paginate(20);

        return DocumentResource::collection($documents);
    }
   

    public function docsPerYear($court_acronym, $year)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('year', $year)
        ->orderBy('year', 'desc')
        ->orderBy('identifier', 'desc')
        ->paginate(20);

        return DocumentResource::collection($documents);
    }

    public function docsPerLang($court_acronym, $lang)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();
        $documents = Document::whereCourtId($court->id)
        ->where('lang', $lang)
        ->orderBy('year', 'desc')
        ->orderBy('identifier', 'desc')
        ->paginate(20);

        return DocumentResource::collection($documents);
    }

    public function docsPerType($court_acronym, $type)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        $documents = Document::whereCourtId($court->id)
        ->where('type', $type)
        ->orderBy('year', 'desc')
        ->orderBy('identifier', 'desc')
        ->paginate(20);

        return DocumentResource::collection($documents);
    }
}
