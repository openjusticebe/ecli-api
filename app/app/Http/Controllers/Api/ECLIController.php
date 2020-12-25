<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Court;

class ECLIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ecli($ecli)
    {
        $arr_colon = explode(":", $ecli);

        if (isset($arr_colon[4])) {
            $arr_type_num = explode('.', $arr_colon[4], 2);
        }
      
        // Redirect to page
        return redirect()->route(
            'documents.show',
            [
                'court_acronym' => $arr_colon[2],
                'year' => $arr_colon[3],
                'type' => $arr_type_num[0],
                'identifier' => $arr_type_num[1]
            ]
        );
    }

    /**
    * @OA\Post(
    * path="/ecli/post",
    * summary="Post new document",
    * description="Post new document",
    * operationId="ECLI",
    * tags={"ECLI"},
    * security={ {"bearer": {} }},
    * @OA\Response(
    *    response=200,
    *    description="Success",
    * )
    * )
    * )
    */

    public function post(Request $request)
    {
        $validated = $this->validate($request, [
                'court_acronym' => 'required|alpha',
                'year' => 'required|integer',
                'type' => 'required|alpha',
                'lang' => 'required|alpha',
                'identifier' => 'required',
                'src' => 'required'
            ]);

        $court = Court::whereAcronym($validated['court_acronym'])->firstOrFail();
        
        $document = $court->documents()->firstOrCreate(
            $request->only(['year', 'type', 'identifier'], // find
            $request->only(['lang', 'src', 'text', 'meta'] // fill if not exist
            )
        );

        return response()->json($document, 201);
    }
}
