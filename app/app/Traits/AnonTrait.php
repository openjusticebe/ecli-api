<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

trait AnonTrait
{
    protected function anonText($text)
    {
        $json_request = [
                "_v" => 1,
                "_timestamp" => Carbon::now()->timestamp,
                "algo_list" => [
                  [
                    "id" => "anon_trazor",
                    "params" => "{\"method\":\"brackets\"}"
                  ],
                  [
                    "id" => "anon_mask",
                    "params" => "{}"
                  ],
                ],
                "format" => "text",
                "encoding" => "utf8",
                "text" => $text
            ];
    
     
        $response = Http::post('https://upl.openjustice.lltl.be/run', $json_request);

        return json_decode($response)->text;
    }

    // curl -X POST "https://upl.openjustice.lltl.be/run" -H  "accept: application/json" -H  "Content-Type: application/json" -d "{\"_v\":1,\"_timestamp\":1239120938,\"algo_list\":[{\"id\":\"anon_trazor\",\"params\":\"{}\"}],\"format\":\"text\",\"encoding\":\"utf8\",\"text\":\"Robert serait le fils d'Erlebert et le neveu de Robert, référendaire de Dagobert Ier.\"}"
        // response example
        // {
//     "_v": 3,
//     "_timestamp": "2021-02-22T09:20:52.838833+00:00",
//     "log": {
//       "lines": [
//         "Found \"Dagobert Ier\" (person #1), score: 1.666",
//         "Found \"Robert\" (person #2), score: 0.5",
//         "Found \"Erlebert\" (person #3), score: 0.5",
//         "Found \"Robert\" (person #4), score: 0.5"
//       ]
//     },
//     "text": "<span class=\"pseudonymized person person_2\">person_2</span> serait le fils de <span class=\"pseudonymized person person_3\">person_3</span> et le neveu de <span class=\"pseudonymized person person_2\">person_2</span>, référendaire de <span class=\"pseudonymized person person_1\">person_1</span>."
        //   }
}
