<?php

namespace App;

use App\Controller\RedirectionController;

class App
{

    public static $allUri = 'all';
    public static $allurlsjsonUri = 'allurlsjson';

    public function run(string $path, ?string $queryParameters): void
    {
        if ($path === '/') {
            echo 'home';
        } elseif ($path === '/' . static::$allUri) {
            echo (new RedirectionController())->list();
        } elseif ($path === '/' . static::$allurlsjsonUri) {
            echo (new RedirectionController())->listUrlsJson();
        } else {
            echo (new RedirectionController())->redirect(substr($path, 1), $queryParameters);
        }
    }
}
