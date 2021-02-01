<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UtuResource;
use App\Models\Utu;
use Cache;

class UtuController extends Controller
{
    /**
    * @OA\Get(
    * path="/utus",
    * summary="Get list of Utus",
    * description="Get list of Utus",
    * operationId="utus",
    * tags={"utu"},
    * @OA\Response(
     *    response=200,
     *    description="Success",
     * )
    * )
    */
    public function index()
    {
        return Cache::rememberForever('utus', function () {
            return $this->getUtus();
        });
    }

    private function getUtus()
    {
        $utus = Utu::whereNull('parent_id')->with('children.children.children')->get();
        return UtuResource::collection($utus);
    }
    
    public function flatIndex()
    {
        return Cache::rememberForever('flatutus', function () {
            return $this->getFlatUtus();
        });
    }

    private function getFlatUtus()
    {
        $utus = Utu::all();
        return UtuResource::collection($utus);
    }
}
