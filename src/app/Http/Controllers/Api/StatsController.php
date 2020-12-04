<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Document;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
    *   Get distinct year from docs
    *   Get distinct courts from count
    *   Loop and build huge array[] and cache it
    *  @return 'stats';
    */
    public function index()
    {
        $courts = Court::get(['id', 'acronym']);
        $years = Document::distinct('year')->pluck('year');
        
        $array = [];
        foreach ($years as $year) {
            foreach ($courts as $court) {
                $array[$court->acronym][$year] = Document::where('year', $year)->where('court_id', $court->id)->count();
            }
        }
        return json_encode($array);
    }
}
