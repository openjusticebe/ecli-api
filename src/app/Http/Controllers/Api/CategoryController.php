<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\HomePageResource;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {

        // return Category::all();
        return Cache::rememberForever('categories_index', function () {
            $category = Category::with(['courts'])->get();

            return new HomePageResource($category);
        });
    }
}
