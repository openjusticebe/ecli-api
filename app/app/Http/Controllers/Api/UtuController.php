<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utu;
use App\Http\Resources\UtuResource;
use Illuminate\Http\Request;
use Cache;

class UtuController extends Controller
{
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
