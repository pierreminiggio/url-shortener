<?php

use App\App;

require __DIR__ . '/../vendor/autoload.php';

$requestUrl = $_SERVER['REQUEST_URI'];
$queryParameters = $_SERVER['QUERY_STRING'] ? ('?' . $_SERVER['QUERY_STRING']) : null;

(new App())->run(
    $queryParameters
        ? str_replace($queryParameters, '', $requestUrl)
        : $requestUrl
    ,
    $queryParameters
);
