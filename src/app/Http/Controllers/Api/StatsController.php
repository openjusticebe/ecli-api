<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Document;
use Illuminate\Http\Request;
use Cache;

class StatsController extends Controller
{
    public function index()
    {
        return Cache::rememberForever('stats', function () {
            return $this->docPerYear();
        });
    }

    /**
      *   Get distinct year from docs
      *   Get court from courts
      *   Loop and build huge array[]
      *  @return 'stats';
      */

    private function docPerYear()
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
