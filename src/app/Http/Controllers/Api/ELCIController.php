<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ELCIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function elci($elci)
    {
        $array_ecli = explode(":", $elci);
        $array_ecli2 = explode('.', $array_ecli[4], 2);



        $route_params = [
            'court_acronym' => $array_ecli[2],
            'year' => $array_ecli[3],
            'type' => $array_ecli2[0],
            'num' => $array_ecli2[1]
        ];
      
        // should redirect to page
        return redirect()->route(
            'documents.show',
            [
                'court_acronym' => $array_ecli[2],
                'year' => $array_ecli[3],
                'type' => $array_ecli2[0],
                'num' => $array_ecli2[1]
            ]
        );
    }
}
