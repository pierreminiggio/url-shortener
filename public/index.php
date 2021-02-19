<?php

use App\App;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$requestUrl = $_SERVER['REQUEST_URI'];
$queryParameters = ! empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : null;

(new App())->run(
    $queryParameters
        ? str_replace($queryParameters, '', $requestUrl)
        : $requestUrl
    ,
    $queryParameters
);
