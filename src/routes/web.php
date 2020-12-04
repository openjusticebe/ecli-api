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



$router->get('/{elci}', 'Api\ELCIController@elci');



// Customs
$router->group(['prefix'=>'api/v1/'], function () use ($router) {
    $router->get('/', [
        'as' => 'base_api',
        'uses' => 'Api\ApiController@index'
    ]);
    $router->get('/stats', 'Api\StatsController@index');
    $router->get('/courts', 'Api\CourtController@index');
    $router->get('/very-secret-password', function () {
        return 'unicorn-pirates-love-pizza';
    });
    $router->get('/amazing', function () {
        return redirect('https://www.youtube.com/watch?v=oHg5SJYRHA0&start=20&fs=1');
    });
});

// ECLI Routing
$router->group(['prefix'=>'api/v1/ELCI/BE'], function () use ($router) {
    $router->get('/', [
        'as' => 'base_ecli_be',
        'uses' => 'Api\CategoryController@index'
    ]);
    
    // List of year and list of category
    $router->get('/{court_acronym}', [
        'as' => 'courts.show',
        'uses' => 'Api\CourtController@show'
    ]);

    $router->get('/{court_acronym}/{year}/', [
        'as' => 'courts.docsPerYear',
        'uses' => 'Api\CourtController@docsPerYear'
    ]);

    $router->get('/{court_acronym}/type/{type}/', [
    'as' => 'courts.docsPerType',
    'uses' => 'Api\CourtController@docsPerType'
    ]);

    $router->get('/{court_acronym}/lang/{lang}/', [
    'as' => 'courts.docsPerLang',
    'uses' => 'Api\CourtController@docsPerLang'
    ]);

    $router->get('/{court_acronym}/{year}/{type}/{num}', [
        'as' => 'documents.show',
        'uses' => 'Api\DocumentController@show'
    ]);
});
