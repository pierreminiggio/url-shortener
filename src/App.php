<?php

namespace App;

use App\Controller\RedirectionController;

class App
{

    public function run(string $path, ?string $queryParameters): void
    {
        if ($path === '/') {
            echo 'home';
        } else {
            echo (new RedirectionController())->redirect(substr($path, 1), $queryParameters);
        }
    }
}
