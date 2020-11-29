<?php

namespace App\Template;

class ErrorTemplate
{

    public function render(int $code): string
    {
        return <<<HTML
            <h1>Error $code</h1>
        HTML;
    }
}
