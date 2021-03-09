<?php

namespace App\Traits;

use App\Models\Court;

trait ECLITrait
{
    protected function explodeECLI(string $ecli)
    {
        $arr_colon = explode(":", $ecli);

        $court = Court::whereAcronym($arr_colon[2])->firstOrFail();

        if (isset($arr_colon[4])) {
            $arr_type_identifier = explode('.', $arr_colon[4], 2);
        
            return [
        'court_id' => $court->id,
        'year' => $arr_colon[3],
        'type' => $arr_type_identifier[0],
        'identifier' => $arr_type_identifier[1]
         ];
        }
    }
}
