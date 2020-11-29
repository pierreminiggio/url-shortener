<?php

namespace App;

use App\Controller\RedirectionController;

class App
{

    public function run(string $path, ?string $queryParameters): void
    {
        echo (new RedirectionController())->redirect($path, $queryParameters);
    }
}
