<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'num' => $arr_type_num[1]
            ]
        );
    }



    public function post(Request $request)
    {
        if ($request->api_key == env('API_KEY')) {
            $this->validate($request, [
                'court_acronym' => 'required|alpha',
                'year' => 'required|integer',
                'type' => 'required|alpha',
                'num' => 'required'
            ]);

            return response()->json($document, 201);
        } else {
            // throw 500
            return response()->json('Sorry', 401);
        }
    }
}
