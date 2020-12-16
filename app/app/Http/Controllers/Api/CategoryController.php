<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\HomePageResource;

class CategoryController extends Controller
{
    public function index()
    {
        return Cache::rememberForever('categories_index', function () {
            $category = Category::with(['courts'])->get();

            return new HomePageResource($category);
        });
    }
}
