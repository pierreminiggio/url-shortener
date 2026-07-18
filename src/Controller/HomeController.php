<?php

namespace App\Controller;

use App\Template\HomeTemplate;
use Exception;

class HomeController
{
    public function index(): string
    {
        $domain = $_SERVER['HTTP_HOST'] ?? null;

        if (! $domain) {
            throw new Exception('Empty $_SERVER[\'HTTP_HOST\']');
        }

        return (new HomeTemplate())->render($domain);
    }
}
