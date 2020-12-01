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
    return $router->app->version();
});

$router->get('/very-secret-password', function () {
    return 'unicorn-pirates-love-pizza';
});

$router->group(['prefix'=>'api/v1/ELCI:BE'], function() use($router){

    $router->get('/', 'Api\CategoryController@index');
    
    $router->get(':{court_acronym}', 'Api\CourtController@show');
    $router->get(':{court_acronym}:{year}', 'Api\CourtController@showPerYear');

    $router->get(':{court_acronym}:{year}:document', 'Api\DocumentController@show');

});

