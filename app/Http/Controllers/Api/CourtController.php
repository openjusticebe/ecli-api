<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
// use Cache;
use App\Http\Resources\CourtResource;

class CourtController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {

        return CourtResource::collection(Court::withCount('documents')->paginate(10));

    }

    public function show($court_acronym)
    {
        $court = Court::whereAcronym($court_acronym)->firstOrFail();

        return new CourtResource($court);
      
    }
}