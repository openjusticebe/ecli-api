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
if (env('FORCE_HTTPS', false)) { // Default value should be false for local server
    URL::forceScheme('https');
}

$router->get('/', function () use ($router) {
    return redirect('api/v1/ECLI/BE');
});

$router->get('/{ecli}', 'Api\ECLIController@ecli');

// Customs
$router->group(['prefix'=>'api/v1/'], function () use ($router) {
    $router->get('/', [
        'as' => 'base_api',
        'uses' => 'Api\ApiController@index',
    ]);

    $router->get('/statistics', 'Api\StatsController@index');
    
    $router->get('/utus', 'Api\UtuController@index');
    $router->post('/utus', 'Api\UtuController@create');
    
    $router->get('/courts', 'Api\CourtController@index');
    $router->get('/very-secret-password', function () {
        return 'unicorn-pirates-love-pizza';
    });
    $router->get('/amazing', function () {
        return redirect('https://www.youtube.com/watch?v=oHg5SJYRHA0&start=20&fs=1');
    });
});

// ECLI Routing
$router->group(['prefix'=>'api/v1/ECLI/BE'], function () use ($router) {
    $router->get('/', [
        'as' => 'base_ecli_be',
        'uses' => 'Api\CategoryController@index',
    ]);

    // List of year and list of category
    $router->get('/{court_acronym}', [
        'as' => 'courts.show',
        'uses' => 'Api\CourtController@show',
    ]);

    $router->get('/{court_acronym}/docsPerYear/{year}/', [
        'as' => 'courts.documents.docsPerYear',
        'uses' => 'Api\DocumentController@docsPerYear',
    ]);

    $router->get('/{court_acronym}/docsPerType/{type}/', [
    'as' => 'courts.documents.docsPerType',
    'uses' => 'Api\DocumentController@docsPerType',
    ]);

    $router->get('/{court_acronym}/docsPerLang/{lang}/', [
    'as' => 'courts.documents.docsPerLang',
    'uses' => 'Api\DocumentController@docsPerLang',
    ]);

    $router->get('/{court_acronym}/docsRecent', [
        'as' => 'courts.documents.docsRecent',
        'uses' => 'Api\DocumentController@docsRecent',
        ]);

    $router->get('/{court_acronym}/{year}/{type_num}', [
        'as' => 'documents.show',
        'uses' => 'Api\DocumentController@show',
    ]);
});
