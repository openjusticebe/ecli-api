<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Cache;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $data = Cache::get('category', function () {
            return Category::with('courts')->get();
        });

        return CategoryResource::collection($data);
    }
}
