<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['prefix' => 'api/v1', 'namespace' => 'App\Api\V1\Controllers'], function ($api) {

    $api->get('test', function () {
        return 'It is ok';
    });
    $api->get('/', function() {
        return ['test' => true];
    });

});

