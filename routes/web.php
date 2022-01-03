<?php

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

$router->get('/lista', 'Pmweb_Orders_StatsController@lista');

$router->get('/getOrdersCount', 'Pmweb_Orders_StatsController@getOrdersCount');
$router->get('/getOrdersRevenue', 'Pmweb_Orders_StatsController@getOrdersRevenue');
$router->get('/getOrdersQuantity', 'Pmweb_Orders_StatsController@getOrdersQuantity');
$router->get('/getOrdersRetailPrice', 'Pmweb_Orders_StatsController@getOrdersRetailPrice');
$router->get('/getOrdersAverageOrderValue', 'Pmweb_Orders_StatsController@getOrdersAverageOrderValue');

$router->get('/returnOrders', 'Pmweb_Orders_StatsController@returnOrders');

