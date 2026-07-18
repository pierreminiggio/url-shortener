<?php

namespace App\Template;

class HomeTemplate
{

    public function render(string $domain): string
    {
        return <<<HTML
            <p>$domain</p>
        HTML;
    }
}
