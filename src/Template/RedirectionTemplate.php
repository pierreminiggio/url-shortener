<?php

namespace App\Template;

use App\Entity\Redirection;

class RedirectionTemplate
{

    public function render(string $newUrl): string
    {
        return <<<HTML
            <a href="$newUrl">Click here if the automatic redirection is not working ...</a>
        HTML;
    }

    /**
     * @param Redirection[] $redirections
     */
    public function renderList(array $redirections): string
    {
        $htmlRedirections = '';

        foreach ($redirections as $redirection) {
            $htmlRedirections .= <<<HTML
                <li><a href="{$redirection->to}">/{$redirection->from}</a></li>
            HTML;
        }

        return <<<HTML
            <h1>Tous les liens</h1>
            <ul>
                $htmlRedirections
            </ul>
        HTML;
    }
}
