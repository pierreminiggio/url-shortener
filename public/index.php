<?php

use App\App;

require __DIR__ . '/../vendor/autoload.php';

(new App())->run($_SERVER['PATH_INFO'], $_SERVER['QUERY_STRING'] ?? null);
