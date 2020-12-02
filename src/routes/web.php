<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('api/v1/ELCI/BE');
});



// Customs
$router->group(['prefix'=>'api/v1/'], function () use ($router) {
    $router->get('/courts', 'Api\CourtController@index');
    $router->get('/very-secret-password', function () {
        return 'unicorn-pirates-love-pizza';
    });
});

// ECLI Routing
$router->group(['prefix'=>'api/v1/ELCI/BE'], function () use ($router) {
    $router->get('/', 'Api\CategoryController@index');
    
    // List of year and list of category
    $router->get('/{court_acronym}', 'Api\CourtController@show');

    // $router->get('/{court_acronym}/{year}', 'Api\CourtController@showPerYear');

    // $router->get('/{court_acronym}/{type}', 'Api\CourtController@showPerYear');

    $router->get('/{court_acronym}/{year}/{type}.{document}', 'Api\DocumentController@show');
});
