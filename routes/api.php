<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('loans', 'LoanController@index');
    $router->get('loans/{id}', 'LoanController@show');
    $router->post('loans', 'LoanController@store');
    $router->put('loans/{id}', 'LoanController@update');
    $router->delete('loans/{id}', 'LoanController@destroy');
});
