<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageResource;
use App\Models\Category;
use Cache;

class CategoryController extends Controller
{
    /**
    * @OA\Get(
    * path="/ECLI/BE",
    * summary="Get list of courts organised by categories",
    * description="Get list of Courts with statistics organised by categories",
    * operationId="Category",
    * tags={"category"},
    * @OA\Response(
    *    response=200,
    *    description="Success",
    * )
    * )
    * )
    */
    public function index()
    {
        return Cache::rememberForever('categories_index', function () {
            $category = Category::with(['courts'])->get();

            return new HomePageResource($category);
        });
    }
}
