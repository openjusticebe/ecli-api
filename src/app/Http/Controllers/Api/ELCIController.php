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
        $arr_colon = explode(":", $elci);

        if (isset($arr_colon[4]) {
            $arr_type_num = explode('.', $arr_colon[4], 2);
        }
      
        // should redirect to page
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
}
