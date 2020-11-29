<?php

namespace App\Template;

class RedirectionTemplate
{

    public function render(string $newUrl): string
    {
        return <<<HTML
            <a href="$newUrl">Click here if the automatic redirection is not working ...</a>
        HTML;
    }
}
