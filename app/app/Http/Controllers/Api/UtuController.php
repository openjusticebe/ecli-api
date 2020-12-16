<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utu;
use App\Http\Resources\UtuResource;
use Illuminate\Http\Request;
use Cache;

class UtuController extends Controller
{
    /**
 * @OA\Get(
 * path="/utus",
 * summary="Get list of Utus",
 * description="Get list of Utus",
 * operationId="utus",
 * tags={"UTU"},
 * security={ {"bearer": {} }},
 * @OA\Response(
 *    response=200,
 *    description="Success",
 * )
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
}
