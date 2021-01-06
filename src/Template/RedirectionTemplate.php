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
                <li><a href="{$redirection->to}" target="_blank">{$redirection->from}</a></li>
            HTML;
        }

        $redirectionsCount = count($redirections);
        $title = 'Aucun lien';

        if ($redirectionsCount === 1) {
            $title = 'Le lien';
        } elseif ($redirectionsCount) {
            $title = 'Les ' . $redirectionsCount . ' liens';
        }

        return <<<HTML
            <h1>$title</h1>
            <ul>
                $htmlRedirections
            </ul>
        HTML;
    }
}
