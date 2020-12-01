<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Cache;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {

        $data = Cache::get('RV', function () {
            $url = 'https://raw.githubusercontent.com/openjusticebe/ecli/master/resources/RVSCDE_def.json';
            return file_get_contents($url);
        });

     return $data;

    }
}